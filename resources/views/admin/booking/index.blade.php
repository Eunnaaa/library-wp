@extends('admin.layout.main')

@section('title', 'Transaksi Booking')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 14px;">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center w-100">
                    <h5 class="font-weight-bold mb-0 text-dark">
                        <i class="fas fa-receipt mr-2 text-primary"></i> Data Transaksi Reservasi Booking
                    </h5>
                    <div class="ml-auto">
                        <span class="badge badge-primary px-3 py-2 font-weight-bold" style="border-radius: 8px;">
                            {{ $booking->count() }} Antrean Aktif
                        </span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table id="example1" class="table table-hover mb-0">
                            <thead>
                                <tr class="bg-light text-center">
                                    <th style="width: 50px;">#</th>
                                    <th>ID Booking</th>
                                    <th>Waktu Booking</th>
                                    <th>Batas Pengambilan</th>
                                    <th class="text-left">Nama Anggota</th>
                                    <th style="width: 130px;">Jumlah Buku</th>
                                    <th style="width: 140px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($booking as $item)
                                    <tr>
                                        <td class="text-center font-weight-bold text-muted">{{ $loop->iteration }}</td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.transaksi.booking.show', $item->id) }}" class="font-weight-bold text-primary">
                                                {{ $item->id_booking }}
                                            </a>
                                        </td>
                                        <td class="text-center small text-muted">{{ date('d M Y, H:i', strtotime($item->tgl_booking)) }}</td>
                                        <td class="text-center"><span class="badge badge-warning font-weight-bold">{{ date('d M Y, H:i', strtotime($item->batas_ambil)) }}</span></td>
                                        <td class="font-weight-500 text-dark">{{ $item->anggota->nama ?? '-' }}</td>
                                        <td class="text-center"><span class="badge badge-info font-weight-bold">{{ $item->booking_detail->count() }} Buku</span></td>
                                        <td class="text-center">
                                            <form action="{{ route('admin.transaksi.booking.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan/menghapus booking ini?');">
                                                <a href="{{ route('admin.transaksi.booking.show', $item->id) }}" class="btn btn-sm btn-primary px-2 py-1 font-weight-bold" data-toggle="tooltip" title="Lihat & Proses Pinjam">
                                                    <i class="fas fa-check-circle mr-1"></i> Proses
                                                </a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger px-2 py-1" data-toggle="tooltip" title="Batalkan Booking">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-5">
                                            <i class="fas fa-receipt fa-3x text-muted mb-2 d-block"></i>
                                            Tidak ada antrean booking aktif saat ini.
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
