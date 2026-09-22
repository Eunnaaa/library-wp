@extends('member.layout.main')

@section('title', 'Data Booking')

@section('content')
<div class="container pt-4">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h4 class="font-weight-bold mb-0 text-primary">
                        <i class="fas fa-receipt mr-2"></i> Bukti Reservasi / Booking Buku
                    </h4>
                    @if(isset($data_booking[0]))
                        <a href="{{ route('member.bookingPdf', $data_booking[0]->id_user) }}" target="_blank" class="btn btn-outline-danger btn-sm font-weight-bold">
                            <i class="fas fa-file-pdf mr-1"></i> Cetak Bukti Booking (PDF)
                        </a>
                    @endif
                </div>
                <div class="card-body">
                    @forelse ($data_booking as $booking)
                        <div class="alert alert-warning border-0 shadow-sm">
                            <h5><i class="fas fa-exclamation-triangle mr-2"></i> Perhatian Pengambilan Buku:</h5>
                            Batas waktu pengambilan buku adalah <strong>1 x 24 jam</strong> sejak waktu booking dilakukan. Mohon datang ke perpustakaan dengan membawa <strong>Bukti Booking</strong> ini atau menunjukkan ID Booking Anda kepada petugas.
                        </div>

                        <div class="bg-light p-3 rounded mb-4 border">
                            <div class="row text-center text-md-left">
                                <div class="col-md-3 mb-2 mb-md-0 border-right">
                                    <span class="text-muted d-block small">ID Booking</span>
                                    <strong class="h5 text-primary">{{ $booking->id_booking }}</strong>
                                </div>
                                <div class="col-md-3 mb-2 mb-md-0 border-right">
                                    <span class="text-muted d-block small">Tanggal Booking</span>
                                    <strong>{{ date('d F Y, H:i', strtotime($booking->tgl_booking)) }} WIB</strong>
                                </div>
                                <div class="col-md-3 mb-2 mb-md-0 border-right">
                                    <span class="text-muted d-block small">Batas Pengambilan</span>
                                    <span class="badge badge-danger p-2">{{ date('d F Y, H:i', strtotime($booking->batas_ambil)) }} WIB</span>
                                </div>
                                <div class="col-md-3">
                                    <span class="text-muted d-block small">Nama Anggota</span>
                                    <strong>{{ $booking->anggota->nama ?? '-' }}</strong>
                                </div>
                            </div>
                        </div>

                        <h5><i class="fas fa-book mr-1"></i> Rincian Buku yang Dipesan:</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover mt-2">
                                <thead class="thead-light">
                                    <tr class="text-center">
                                        <th style="width: 40px;">#</th>
                                        <th style="width: 80px;">Cover</th>
                                        <th>Judul Buku</th>
                                        <th>Kategori</th>
                                        <th>Pengarang</th>
                                        <th>Penerbit</th>
                                        <th style="width: 80px;">Tahun</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($booking->booking_detail as $detail)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">
                                                <img src="{{ asset('storage/' . ($detail->buku->image ?? 'cover-buku/book-default-cover.jpg')) }}"
                                                    class="img-thumbnail" width="50" style="object-fit: cover;" alt="Cover Buku">
                                            </td>
                                            <td><strong>{{ $detail->buku->judul_buku ?? 'Buku Tidak Tersedia' }}</strong></td>
                                            <td><span class="badge badge-info">{{ $detail->buku->kategori->nama_kategori ?? '-' }}</span></td>
                                            <td>{{ $detail->buku->pengarang ?? '-' }}</td>
                                            <td>{{ $detail->buku->penerbit ?? '-' }}</td>
                                            <td class="text-center">{{ $detail->buku->tahun_terbit ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="fas fa-receipt fa-4x mb-3 text-secondary"></i>
                            <h5>Tidak ada buku yang sedang dibooking saat ini.</h5>
                            <a href="{{ route('member.index') }}" class="btn btn-primary mt-2">Lihat Katalog Buku</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
