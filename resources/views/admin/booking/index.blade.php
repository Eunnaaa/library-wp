@extends('admin.layout.main')

@section('title', 'Transaksi Booking')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-receipt mr-1"></i> Data Transaksi Booking</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr class="text-center">
                                    <th style="width: 40px;">#</th>
                                    <th>ID Booking</th>
                                    <th>Tanggal Booking</th>
                                    <th>Batas Ambil</th>
                                    <th>Nama Anggota</th>
                                    <th style="width: 100px;">Jumlah Buku</th>
                                    <th style="width: 120px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($booking as $item)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td><strong>{{ $item->id_booking }}</strong></td>
                                        <td>{{ date('d-m-Y H:i', strtotime($item->tgl_booking)) }}</td>
                                        <td><span class="badge badge-warning">{{ date('d-m-Y H:i', strtotime($item->batas_ambil)) }}</span></td>
                                        <td>{{ $item->anggota->nama ?? '-' }}</td>
                                        <td class="text-center"><span class="badge badge-info">{{ $item->booking_detail->count() }} Buku</span></td>
                                        <td class="text-center">
                                            <form action="{{ route('admin.transaksi.booking.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan/menghapus booking ini?');">
                                                <a href="{{ route('admin.transaksi.booking.show', $item->id) }}" class="btn btn-xs btn-primary" data-toggle="tooltip" title="Lihat & Proses Pinjam">
                                                    <i class="fas fa-eye"></i> Proses
                                                </a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-xs btn-danger" data-toggle="tooltip" title="Hapus Booking">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-3">Tidak ada data booking yang sedang aktif.</td>
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
