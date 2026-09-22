<?php

namespace Tests\Feature;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LibraryTest extends TestCase
{
    public function test_catalog_page_is_accessible(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Katalog E-Library UNM');
    }

    public function test_login_page_is_accessible(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('E-Library');
    }

    public function test_register_page_is_accessible(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
        $response->assertSee('Daftar Akun Anggota Baru');
    }

    public function test_admin_dashboard_requires_auth(): void
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');
    }

    public function test_admin_can_access_dashboard_and_masters(): void
    {
        $admin = User::where('role_id', 1)->first();

        $response = $this->actingAs($admin)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Dashboard');

        $response = $this->actingAs($admin)->get('/admin/master/user');
        $response->assertStatus(200);

        $response = $this->actingAs($admin)->get('/admin/master/kategori');
        $response->assertStatus(200);

        $response = $this->actingAs($admin)->get('/admin/master/buku');
        $response->assertStatus(200);

        $response = $this->actingAs($admin)->get('/admin/transaksi/booking');
        $response->assertStatus(200);

        $response = $this->actingAs($admin)->get('/admin/transaksi/peminjaman');
        $response->assertStatus(200);
    }

    public function test_member_can_add_to_cart_and_view_cart(): void
    {
        $member = User::where('role_id', 2)->first();
        $buku = Buku::where('stok', '>', 0)->first();

        $response = $this->actingAs($member)->post('/member/tambah-ke-keranjang', [
            'id' => $buku->id,
        ]);
        $response->assertRedirect('/');

        $response = $this->actingAs($member)->get('/member/data-keranjang/' . $member->id);
        $response->assertStatus(200);
        $response->assertSee('Keranjang Peminjaman Buku');
    }

    public function test_detail_buku_json_endpoint(): void
    {
        $buku = Buku::first();
        $response = $this->get('/detail-buku/' . $buku->id);
        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'judul_buku', 'pengarang', 'penerbit', 'stok']);
    }

    public function test_full_booking_and_borrowing_workflow(): void
    {
        $member = User::where('role_id', 2)->first();
        $admin = User::where('role_id', 1)->first();
        $buku = Buku::where('stok', '>', 0)->first();
        $initialStock = $buku->stok;

        // 1. Member adds to cart
        $this->actingAs($member)->post('/member/tambah-ke-keranjang', ['id' => $buku->id]);

        // 2. Member checks out / saves booking
        $response = $this->actingAs($member)->post('/member/simpan-booking', ['id' => $member->id]);
        $response->assertRedirect('/member/data-booking/' . $member->id);

        // Assert stock decremented & dibooking incremented
        $buku->refresh();
        $this->assertEquals($initialStock - 1, $buku->stok);
        $this->assertEquals(1, $buku->dibooking);

        // 3. Member generates booking PDF
        $responsePdf = $this->actingAs($member)->get('/member/booking-pdf/' . $member->id);
        $responsePdf->assertStatus(200);
        $this->assertEquals('application/pdf', $responsePdf->headers->get('content-type'));

        // 4. Admin processes booking into loan (Peminjaman)
        $booking = \App\Models\Booking::where('id_user', $member->id)->first();
        $this->assertNotNull($booking);

        $responseLoan = $this->actingAs($admin)->post('/admin/transaksi/peminjaman', [
            'id_booking' => $booking->id_booking,
            'lama' => [7],
            'denda' => [1000],
        ]);
        $responseLoan->assertRedirect('/admin/transaksi/peminjaman');

        // Assert booking converted to pinjam
        $pinjam = \App\Models\Pinjam::where('id_user', $member->id)->latest()->first();
        $this->assertNotNull($pinjam);
        $buku->refresh();
        $this->assertEquals(0, $buku->dibooking);
        $this->assertEquals(1, $buku->dipinjam);

        // 5. Admin returns the book (Pengembalian)
        $responseReturn = $this->actingAs($admin)->put(
            '/admin/transaksi/pinjam/kembalikanBuku/' . $pinjam->no_pinjam . '/' . $buku->id
        );
        $responseReturn->assertStatus(200);
        $responseReturn->assertJson(['success' => 'Buku berhasil dikembalikan.']);

        // Assert book stock restored
        $buku->refresh();
        $this->assertEquals($initialStock, $buku->stok);
        $this->assertEquals(0, $buku->dipinjam);

        // 6. Admin exports report
        $exportPdf = $this->actingAs($admin)->get('/admin/transaksi/export-pdf-pinjam');
        $exportPdf->assertStatus(200);
        $this->assertEquals('application/pdf', $exportPdf->headers->get('content-type'));
    }
}
