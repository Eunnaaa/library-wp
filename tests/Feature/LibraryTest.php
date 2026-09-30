<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Buku;
use App\Models\Pinjam;
use App\Models\PinjamDetail;
use App\Models\Temp;
use App\Models\User;
use Tests\TestCase;

class LibraryTest extends TestCase
{
    public function test_catalog_page_is_accessible(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Katalog E-Library UNM');
    }

    public function test_admin_can_access_catalog_page(): void
    {
        $admin = User::where('role_id', 1)->first();
        $response = $this->actingAs($admin)->get('/');
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
        Temp::where('id_user', $member->id)->delete();
        $buku = Buku::where('stok', '>', 0)->first();

        $response = $this->actingAs($member)->post('/member/tambah-ke-keranjang', [
            'id' => $buku->id,
        ]);
        $response->assertRedirect('/');

        $response = $this->actingAs($member)->get('/member/data-keranjang/'.$member->id);
        $response->assertStatus(200);
        $response->assertSee('Keranjang Peminjaman Buku');

        Temp::where('id_user', $member->id)->delete();
    }

    public function test_detail_buku_json_endpoint(): void
    {
        $buku = Buku::first();
        $response = $this->get('/detail-buku/'.$buku->id);
        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'judul_buku', 'pengarang', 'penerbit', 'stok']);
    }

    public function test_full_booking_and_borrowing_workflow(): void
    {
        $member = User::where('role_id', 2)->first();
        $admin = User::where('role_id', 1)->first();
        Temp::where('id_user', $member->id)->delete();
        Booking::where('id_user', $member->id)->delete();
        $buku = Buku::where('stok', '>', 0)->first();
        $initialStock = $buku->stok;

        // 1. Member adds to cart
        $this->actingAs($member)->post('/member/tambah-ke-keranjang', ['id' => $buku->id]);

        // 2. Member checks out / saves booking
        $response = $this->actingAs($member)->post('/member/simpan-booking', ['id' => $member->id]);
        $response->assertRedirect('/member/data-booking/'.$member->id);

        // Assert stock decremented & dibooking incremented
        $buku->refresh();
        $this->assertEquals($initialStock - 1, $buku->stok);
        $this->assertEquals(1, $buku->dibooking);

        // 3. Member generates booking PDF
        $responsePdf = $this->actingAs($member)->get('/member/booking-pdf/'.$member->id);
        $responsePdf->assertStatus(200);
        $this->assertEquals('application/pdf', $responsePdf->headers->get('content-type'));

        // 4. Admin processes booking into loan (Peminjaman)
        $booking = Booking::where('id_user', $member->id)->first();
        $this->assertNotNull($booking);

        $responseLoan = $this->actingAs($admin)->post('/admin/transaksi/peminjaman', [
            'id_booking' => $booking->id_booking,
            'lama' => [7],
            'denda' => [1000],
        ]);
        $responseLoan->assertRedirect('/admin/transaksi/peminjaman');

        // Assert booking converted to pinjam
        $pinjam = Pinjam::where('id_user', $member->id)->latest()->first();
        $this->assertNotNull($pinjam);
        $buku->refresh();
        $this->assertEquals(0, $buku->dibooking);
        $this->assertEquals(1, $buku->dipinjam);

        // 5. Admin returns the book (Pengembalian)
        $responseReturn = $this->actingAs($admin)->put(
            '/admin/transaksi/pinjam/kembalikanBuku/'.$pinjam->no_pinjam.'/'.$buku->id
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

    public function test_member_cannot_access_other_member_cart_or_booking(): void
    {
        $memberA = User::factory()->create(['role_id' => 2]);
        $memberB = User::factory()->create(['role_id' => 2]);

        // Member A should not be able to view Member B's cart
        $responseCart = $this->actingAs($memberA)->get('/member/data-keranjang/'.$memberB->id);
        $responseCart->assertStatus(403);

        // Member A should not be able to view Member B's booking data
        $responseBooking = $this->actingAs($memberA)->get('/member/data-booking/'.$memberB->id);
        $responseBooking->assertStatus(403);

        // Member A should not be able to download Member B's booking PDF
        $responsePdf = $this->actingAs($memberA)->get('/member/booking-pdf/'.$memberB->id);
        $responsePdf->assertStatus(403);
    }

    public function test_late_book_return_calculates_integer_denda(): void
    {
        $admin = User::where('role_id', 1)->first();
        $member = User::where('role_id', 2)->first();
        $buku = Buku::where('stok', '>', 0)->first();

        $no_pinjam = 'P'.date('ymd').rand(100, 999);
        try {
            $pinjam = Pinjam::create([
                'no_pinjam' => $no_pinjam,
                'tgl_pinjam' => now()->subDays(10),
                'id_booking' => 'BTEST'.rand(100, 999),
                'id_user' => $member->id,
                'total_denda' => 0,
                'id_petugas_pinjam' => $admin->id,
            ]);

            $detail = PinjamDetail::create([
                'no_pinjam' => $no_pinjam,
                'id_buku' => $buku->id,
                'tgl_kembali' => now()->subDays(3)->format('Y-m-d H:i:s'),
                'denda' => 1000,
                'lama_pinjam' => 7,
                'status' => 'Pinjam',
            ]);
            $buku->increment('dipinjam');

            $response = $this->actingAs($admin)->put(
                '/admin/transaksi/pinjam/kembalikanBuku/'.$no_pinjam.'/'.$buku->id
            );
            $response->assertStatus(200);

            $detail->refresh();
            $this->assertEquals('Kembali', $detail->status);
            $this->assertEquals(3000, $detail->total_denda);
        } finally {
            PinjamDetail::where('no_pinjam', $no_pinjam)->delete();
            Pinjam::where('no_pinjam', $no_pinjam)->delete();
        }
    }

    public function test_admin_cannot_delete_own_account(): void
    {
        $admin = User::where('role_id', 1)->first();
        $response = $this->actingAs($admin)->delete('/admin/master/user/'.$admin->id);
        $response->assertRedirect('/admin/master/user');
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_login_uses_uniform_error_message(): void
    {
        // 1. Non-existent email
        $response1 = $this->post('/login', [
            'email' => 'doesnotexist@example.com',
            'password' => 'wrongpassword',
        ]);
        $response1->assertSessionHas('error', 'Email atau password yang Anda masukkan salah!');

        // 2. Existing user, wrong password
        $user = User::first();
        $response2 = $this->post('/login', [
            'email' => $user->email,
            'password' => 'absolutelywrongpass',
        ]);
        $response2->assertSessionHas('error', 'Email atau password yang Anda masukkan salah!');
    }

    public function test_admin_buku_search_and_filter(): void
    {
        $admin = User::where('role_id', 1)->first();
        $buku = Buku::first();

        // Search by title keyword
        $response = $this->actingAs($admin)->get('/admin/master/buku?keyword='.urlencode(substr($buku->judul_buku, 0, 4)));
        $response->assertStatus(200);
        $response->assertSee($buku->judul_buku);

        // Filter by category
        $responseCategory = $this->actingAs($admin)->get('/admin/master/buku?id_kategori='.$buku->id_kategori);
        $responseCategory->assertStatus(200);
        $responseCategory->assertSee($buku->judul_buku);
    }

    public function test_admin_user_search_and_filter(): void
    {
        $admin = User::where('role_id', 1)->first();
        $member = User::where('role_id', 2)->latest()->first();

        // Search by member email
        $response = $this->actingAs($admin)->get('/admin/master/user?keyword='.urlencode($member->email));
        $response->assertStatus(200);
        $response->assertSee($member->nama);

        // Filter by role
        $responseRole = $this->actingAs($admin)->get('/admin/master/user?role_id=2');
        $responseRole->assertStatus(200);
        $responseRole->assertSee($member->nama);
    }
}
