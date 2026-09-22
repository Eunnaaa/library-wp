@extends('member.layout.main')

@section('title', 'Keranjang Buku')

@section('content')
<div class="container pt-4">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h4 class="font-weight-bold mb-0 text-primary">
                        <i class="fas fa-shopping-basket mr-2"></i> Keranjang Peminjaman Buku
                    </h4>
                    <div>
                        <a href="{{ route('member.index') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-arrow-left mr-1"></i> Lanjutkan Pencarian Buku
                        </a>
                        @if(!$temp->isEmpty())
                            <form action="{{ route('member.simpanBooking') }}" method="POST" class="d-inline ml-2">
                                @csrf
                                <input type="hidden" name="id" value="{{ auth()->user()->id }}">
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fas fa-check-circle mr-1"></i> Selesai Booking
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="alert alert-info border-0 shadow-sm">
                        <i class="fas fa-info-circle mr-1"></i> Anda dapat memesan maksimal <strong>3 buku</strong> sekaligus. Setelah menekan tombol <strong>Selesai Booking</strong>, Anda memiliki waktu 1x24 jam untuk mengambil buku fisik di perpustakaan.
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="thead-light">
                                <tr class="text-center">
                                    <th style="width: 40px;">#</th>
                                    <th style="width: 80px;">Cover</th>
                                    <th>Judul Buku</th>
                                    <th>Kategori</th>
                                    <th>Pengarang</th>
                                    <th>Penerbit</th>
                                    <th style="width: 80px;">Tahun</th>
                                    <th style="width: 90px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($temp as $item)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">
                                            <img src="{{ asset('storage/' . ($item->buku->image ?? 'cover-buku/book-default-cover.jpg')) }}"
                                                class="img-thumbnail" width="60" style="object-fit: cover;" alt="Cover Buku">
                                        </td>
                                        <td><strong>{{ $item->buku->judul_buku ?? 'Buku Tidak Ditemukan' }}</strong></td>
                                        <td><span class="badge badge-info">{{ $item->buku->kategori->nama_kategori ?? '-' }}</span></td>
                                        <td>{{ $item->buku->pengarang ?? '-' }}</td>
                                        <td>{{ $item->buku->penerbit ?? '-' }}</td>
                                        <td class="text-center">{{ $item->buku->tahun_terbit ?? '-' }}</td>
                                        <td class="text-center">
                                            <form action="{{ route('member.hapusKeranjang', ['buku' => $item->id_buku, 'user' => auth()->user()->id]) }}" method="POST"
                                                onsubmit="return confirm('Hapus buku ini dari keranjang?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="fas fa-trash-alt"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-5">
                                            <i class="fas fa-shopping-basket fa-3x mb-3 text-secondary d-block"></i>
                                            <h5>Keranjang Anda masih kosong.</h5>
                                            <p>Silakan pilih buku yang ingin dipinjam dari katalog buku kami.</p>
                                            <a href="{{ route('member.index') }}" class="btn btn-primary mt-2">
                                                <i class="fas fa-book-open mr-1"></i> Buka Katalog Buku
                                            </a>
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
