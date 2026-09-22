@extends('admin.layout.main')

@section('title', 'Transaksi Pengembalian')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-success shadow-sm">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-history mr-1"></i> Riwayat Pengembalian Buku</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped table-hover" style="font-size: small">
                            <thead class="thead-light">
                                <tr class="text-center">
                                    <th style="width: 30px;">#</th>
                                    <th>No. Pinjam</th>
                                    <th>Tgl. Pinjam</th>
                                    <th>Batas Kembali</th>
                                    <th>Lama Pinjam</th>
                                    <th>Tgl. Dikembalikan</th>
                                    <th>Judul Buku</th>
                                    <th>Status</th>
                                    <th>Keterangan Denda</th>
                                    <th>Cover</th>
                                    <th>Petugas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data_pinjam as $pinjam)
                                    @foreach ($pinjam->pinjam_detail as $detail)
                                        <tr>
                                            <td class="text-center">{{ $loop->parent->iteration }}</td>
                                            <td><strong>{{ $pinjam->no_pinjam }}</strong></td>
                                            <td class="text-center">{{ date('d-m-Y', strtotime($pinjam->tgl_pinjam)) }}</td>
                                            <td class="text-center">{{ date('d-m-Y', strtotime($detail->tgl_kembali)) }}</td>
                                            <td class="text-center">{{ $detail->lama_pinjam }} hari</td>
                                            <td class="text-center">
                                                {{ $detail->tgl_pengembalian ? date('d-m-Y H:i', strtotime($detail->tgl_pengembalian)) : '-' }}
                                            </td>
                                            <td>{{ $detail->buku->judul_buku ?? 'Buku Tidak Ada' }}</td>
                                            <td class="text-center">
                                                <span class="badge badge-success">{{ $detail->status }}</span>
                                            </td>
                                            <td>
                                                @php
                                                    $tglKembali = \Carbon\Carbon::parse($detail->tgl_kembali);
                                                    $tglPengembalian = $detail->tgl_pengembalian ? \Carbon\Carbon::parse($detail->tgl_pengembalian) : now();
                                                    $terlambat = max(0, $tglPengembalian->diffInDays($tglKembali, false) * -1);
                                                    $totalDenda = $terlambat * $detail->denda;
                                                @endphp
                                                <b>Tarif/Hari:</b> Rp {{ number_format($detail->denda, 0, ',', '.') }}<br>
                                                <b>Terlambat:</b> {{ $terlambat }} hari<br>
                                                <b>Total Denda:</b> <span class="text-danger font-weight-bold">Rp {{ number_format($totalDenda, 0, ',', '.') }}</span>
                                            </td>
                                            <td class="text-center">
                                                <img src="{{ asset('storage/' . ($detail->buku->image ?? 'cover-buku/book-default-cover.jpg')) }}"
                                                    width="50" class="img-thumbnail" alt="Cover">
                                            </td>
                                            <td>{{ $detail->petugas_kembali->nama ?? ($pinjam->petugas_pinjam->nama ?? '-') }}</td>
                                        </tr>
                                    @endforeach
                                @empty
                                    <tr>
                                        <td colspan="11" class="text-center text-muted py-3">Belum ada riwayat buku yang dikembalikan.</td>
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
