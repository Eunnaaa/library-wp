@extends('admin.layout.main')

@section('title', 'Transaksi Booking Perpustakaan')

@section('content')
<div class="container-fluid pb-4">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 14px;">
                <div class="card-header bg-white py-3 border-bottom d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                    <div>
                        <h5 class="font-weight-bold mb-1 text-dark">
                            <i class="fas fa-receipt mr-2 text-primary"></i> Antrean Reservasi Booking Anggota
                        </h5>
                        <p class="text-muted small mb-0">Verifikasi pengambilan buku fisik dan konfirmasi sirkulasi pinjam sebelum batas waktu kedaluwarsa</p>
                    </div>
                    <div class="mt-2 mt-md-0">
                        <span class="badge badge-primary px-3 py-2 font-weight-bold" style="border-radius: 8px;">
                            <i class="fas fa-clock mr-1"></i> {{ $booking->count() }} Antrean Aktif
                        </span>
                    </div>
                </div>

                <div class="card-body p-3">
                    <div class="table-responsive">
                        <table id="booking-table" class="table table-hover align-middle mb-0" style="width: 100%;">
                            <thead class="thead-light">
                                <tr class="text-center">
                                    <th style="width: 50px;">#</th>
                                    <th>ID Booking</th>
                                    <th>Waktu Booking</th>
                                    <th>Batas Pengambilan</th>
                                    <th class="text-left">Nama Anggota</th>
                                    <th style="width: 130px;">Jumlah Buku</th>
                                    <th style="width: 150px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($booking as $item)
                                    <tr>
                                        <td class="text-center font-weight-bold text-muted">{{ $loop->iteration }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.transaksi.booking.show', $item->id) }}" class="font-weight-bold text-primary" title="Lihat rincian">
                                                <i class="fas fa-ticket-alt mr-1"></i> {{ $item->id_booking }}
                                            </a>
                                        </td>
                                        <td class="text-center small text-muted">
                                            <div>{{ date('d M Y', strtotime($item->tgl_booking)) }}</div>
                                            <div class="font-weight-bold">{{ date('H:i', strtotime($item->tgl_booking)) }} WIB</div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-warning px-2 py-1 font-weight-bold" style="border-radius: 6px;">
                                                <i class="fas fa-hourglass-half mr-1"></i> {{ date('d M Y, H:i', strtotime($item->batas_ambil)) }}
                                            </span>
                                        </td>
                                        <td>
                                            <strong class="text-dark d-block">{{ $item->anggota->nama ?? '-' }}</strong>
                                            <small class="text-muted">{{ $item->anggota->email ?? '' }}</small>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-info px-2 py-1 font-weight-bold">
                                                <i class="fas fa-book mr-1"></i> {{ $item->booking_detail->count() }} Judul
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.transaksi.booking.show', $item->id) }}" class="btn btn-sm btn-primary px-3 py-1 font-weight-bold shadow-sm" data-toggle="tooltip" title="Verifikasi & Proses Peminjaman">
                                                    <i class="fas fa-check-circle mr-1"></i> Proses
                                                </a>
                                                <form action="{{ route('admin.transaksi.booking.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan/menghapus booking ini? Stok buku akan dikembalikan.');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger px-2 py-1" data-toggle="tooltip" title="Batalkan Reservasi" style="border-top-left-radius: 0; border-bottom-left-radius: 0;">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-5">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 70px; height: 70px; background: #eff6ff;">
                                                <i class="fas fa-receipt fa-2x text-primary"></i>
                                            </div>
                                            <h6 class="font-weight-bold text-dark">Tidak Ada Antrean Booking Aktif</h6>
                                            <p class="small text-muted mb-0">Semua reservasi buku telah diproses atau belum ada anggota yang melakukan booking.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        if ($('#booking-table tbody tr').length > 0 && !$('#booking-table tbody tr td').hasClass('text-muted')) {
            $('#booking-table').DataTable({
                responsive: true,
                autoWidth: false,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Cari antrean booking...",
                    lengthMenu: "Tampilkan _MENU_ antrean",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ booking",
                    infoEmpty: "Menampilkan 0 booking",
                    infoFiltered: "(disaring dari _MAX_ total data)",
                    zeroRecords: "Tidak ada data booking yang cocok",
                    paginate: {
                        first: '<i class="fas fa-angle-double-left"></i>',
                        previous: '<i class="fas fa-angle-left"></i>',
                        next: '<i class="fas fa-angle-right"></i>',
                        last: '<i class="fas fa-angle-double-right"></i>'
                    }
                }
            });
        }
    });
</script>
@endpush
