@extends('admin.layout.main')

@section('title', 'Data Booking')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-body">
                    <form action="{{ route('admin.transaksi.peminjaman.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_booking" value="{{ $data_booking[0]->id_booking }}">

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="alert alert-info shadow-sm" role="alert">
                                    <i class="fas fa-info-circle mr-1"></i> Waktu Pengambilan Buku 1x24 jam dari waktu booking! Jika buku diambil, tentukan tarif denda per hari dan durasi peminjaman, kemudian klik <strong>Proses Pinjam</strong>.
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-12 d-flex flex-wrap align-items-center bg-light p-3 rounded border">
                                <div class="mr-4">
                                    <span class="text-muted d-block small">ID Booking</span>
                                    <strong class="h5 text-primary">{{ $data_booking[0]->id_booking }}</strong>
                                </div>
                                <div class="mr-4 border-left pl-3">
                                    <span class="text-muted d-block small">Tanggal Booking</span>
                                    <strong>{{ date('d-m-Y H:i', strtotime($data_booking[0]->tgl_booking)) }}</strong>
                                </div>
                                <div class="mr-4 border-left pl-3">
                                    <span class="text-muted d-block small">Batas Ambil</span>
                                    <span class="badge badge-warning text-dark">{{ date('d-m-Y H:i', strtotime($data_booking[0]->batas_ambil)) }}</span>
                                </div>
                                <div class="mr-4 border-left pl-3">
                                    <span class="text-muted d-block small">Anggota Peminjam</span>
                                    <strong>{{ $data_booking[0]->anggota->nama ?? '-' }}</strong>
                                </div>
                                <div class="ml-auto mt-2 mt-md-0">
                                    <a href="{{ route('admin.transaksi.booking.index') }}" class="btn btn-outline-secondary mr-2"><i class="fas fa-arrow-left"></i> Kembali</a>
                                    <button type="submit" class="btn btn-success"><i class="fas fa-check-circle mr-1"></i> Proses Pinjam</button>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <h5><i class="fas fa-book mr-1"></i> Rincian Buku yang Dibooking:</h5>
                                <div class="table-responsive">
                                    <table id="data-booking" class="table table-bordered table-striped mt-2">
                                        <thead class="thead-light">
                                            <tr class="text-center">
                                                <th style="width: 40px;">#</th>
                                                <th>Judul Buku</th>
                                                <th>Kategori</th>
                                                <th>Pengarang</th>
                                                <th>Penerbit</th>
                                                <th>Tahun</th>
                                                <th style="width: 150px;">Tarif Denda/Hari (Rp) <span class="text-danger">*</span></th>
                                                <th style="width: 140px;">Lama Pinjam (Hari) <span class="text-danger">*</span></th>
                                                <th style="width: 100px;">Cover</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data_booking as $booking)
                                                @foreach ($booking->booking_detail as $detail)
                                                    <tr>
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        <td><strong>{{ $detail->buku->judul_buku ?? 'Buku Dihapus' }}</strong></td>
                                                        <td><span class="badge badge-info">{{ $detail->buku->kategori->nama_kategori ?? '-' }}</span></td>
                                                        <td>{{ $detail->buku->pengarang ?? '-' }}</td>
                                                        <td>{{ $detail->buku->penerbit ?? '-' }}</td>
                                                        <td class="text-center">{{ $detail->buku->tahun_terbit ?? '-' }}</td>
                                                        <td>
                                                            <div class="input-group input-group-sm">
                                                                <div class="input-group-prepend"><span class="input-group-text">Rp</span></div>
                                                                <input type="number" class="form-control" name="denda[]" value="1000" min="0" required>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-group input-group-sm">
                                                                <input type="number" class="form-control text-center" name="lama[]" value="7" min="1" max="30" required>
                                                                <div class="input-group-append"><span class="input-group-text">Hari</span></div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center">
                                                            <img src="{{ asset('storage/' . ($detail->buku->image ?? 'cover-buku/book-default-cover.jpg')) }}"
                                                                class="img-thumbnail" width="60" style="object-fit: cover;" alt="Cover Buku">
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
