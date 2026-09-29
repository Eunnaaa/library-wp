@extends('admin.layout.main')

@section('title', 'Riwayat Pengembalian')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-xl overflow-hidden mb-4">
                <div class="card-header bg-white border-0 pt-4 pb-2 px-4 d-flex flex-column flex-md-row align-items-md-center justify-content-between w-100">
                    <div>
                        <h4 class="font-weight-bold text-dark mb-1">
                            <i class="fas fa-history text-success mr-2"></i>Riwayat Transaksi Pengembalian Buku
                        </h4>
                        <p class="text-muted small mb-0">Arsip pencatatan pengembalian buku dan kalkulasi denda keterlambatan</p>
                    </div>
                    <div class="mt-2 mt-md-0 ml-md-auto">
                        <a href="{{ route('admin.transaksi.peminjaman.index') }}" class="btn btn-outline-primary btn-sm px-3">
                            <i class="fas fa-exchange-alt mr-1"></i> Data Peminjaman Aktif
                        </a>
                    </div>
                </div>

                <div class="card-body px-4 pt-3">
                    <div class="table-responsive">
                        <table id="example1" class="table table-hover align-middle border rounded-lg overflow-hidden">
                            <thead class="thead-light">
                                <tr>
                                    <th class="text-center" style="width: 40px;">#</th>
                                    <th>No. Pinjam</th>
                                    <th>Cover</th>
                                    <th>Judul Buku</th>
                                    <th>Tgl Pinjam</th>
                                    <th>Batas Kembali</th>
                                    <th>Tgl Dikembalikan</th>
                                    <th class="text-center">Status</th>
                                    <th>Rincian Denda</th>
                                    <th>Petugas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data_pinjam as $pinjam)
                                    @foreach ($pinjam->pinjam_detail as $detail)
                                        <tr>
                                            <td class="text-center align-middle font-weight-bold text-muted">{{ $loop->parent->iteration }}</td>
                                            <td class="align-middle">
                                                <span class="badge badge-light border font-weight-bold text-primary px-2 py-1" style="font-size: 0.85rem;">
                                                    {{ $pinjam->no_pinjam }}
                                                </span>
                                                <small class="text-muted d-block mt-1">
                                                    {{ $pinjam->anggota->nama ?? '-' }}
                                                </small>
                                            </td>
                                            <td class="align-middle text-center">
                                                <img src="{{ asset('storage/' . ($detail->buku->image ?? 'cover-buku/book-default-cover.jpg')) }}"
                                                    class="rounded shadow-sm" width="46" height="62" style="object-fit: cover;" alt="Cover">
                                            </td>
                                            <td class="align-middle">
                                                <strong class="text-dark d-block mb-1">{{ $detail->buku->judul_buku ?? 'Buku Tidak Ada' }}</strong>
                                                <span class="badge badge-primary px-2 py-1" style="font-size: 0.72rem; border-radius: 4px;">
                                                    {{ $detail->buku->kategori->nama_kategori ?? '-' }}
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                <span class="text-muted small d-block">Pinjam:</span>
                                                <strong>{{ date('d-m-Y', strtotime($pinjam->tgl_pinjam)) }}</strong>
                                            </td>
                                            <td class="align-middle">
                                                <span class="text-muted small d-block">Batas:</span>
                                                <strong class="text-dark">{{ date('d-m-Y', strtotime($detail->tgl_kembali)) }}</strong>
                                                <small class="text-muted d-block">({{ $detail->lama_pinjam }} hari)</small>
                                            </td>
                                            <td class="align-middle">
                                                @if($detail->tgl_pengembalian)
                                                    <span class="text-success font-weight-bold d-block">
                                                        <i class="fas fa-calendar-check mr-1"></i>{{ date('d-m-Y', strtotime($detail->tgl_pengembalian)) }}
                                                    </span>
                                                    <small class="text-muted">{{ date('H:i', strtotime($detail->tgl_pengembalian)) }} WIB</small>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td class="text-center align-middle">
                                                <span class="badge badge-success px-2 py-1 font-weight-bold" style="border-radius: 6px;">
                                                    <i class="fas fa-check mr-1"></i>{{ $detail->status }}
                                                </span>
                                            </td>
                                            <td class="align-middle">
                                                @php
                                                    $tglKembali = \Carbon\Carbon::parse($detail->tgl_kembali);
                                                    $tglPengembalian = $detail->tgl_pengembalian ? \Carbon\Carbon::parse($detail->tgl_pengembalian) : now();
                                                    $terlambat = max(0, $tglPengembalian->diffInDays($tglKembali, false) * -1);
                                                    $totalDenda = $terlambat * $detail->denda;
                                                @endphp

                                                @if($totalDenda > 0)
                                                    <div class="p-2 rounded bg-light border border-danger-light">
                                                        <span class="badge badge-danger px-2 py-1 mb-1">
                                                            <i class="fas fa-exclamation-circle mr-1"></i>Terlambat {{ $terlambat }} Hari
                                                        </span>
                                                        <div class="small text-muted">Tarif: Rp {{ number_format($detail->denda, 0, ',', '.') }}/hari</div>
                                                        <div class="font-weight-bold text-danger mt-1">
                                                            Denda: Rp {{ number_format($totalDenda, 0, ',', '.') }}
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="badge badge-light border text-success px-2 py-1">
                                                        <i class="fas fa-check-circle mr-1"></i>Tepat Waktu (Rp 0)
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="align-middle text-muted small">
                                                <i class="fas fa-user-check mr-1 text-primary"></i>
                                                {{ $detail->petugas_kembali->nama ?? ($pinjam->petugas_pinjam->nama ?? '-') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center text-muted py-4">Belum ada riwayat buku yang dikembalikan.</td>
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
        if ($('#example1').length) {
            $('#example1').DataTable({
                responsive: true,
                autoWidth: false,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Cari riwayat pengembalian...",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ riwayat",
                    infoEmpty: "Menampilkan 0 data",
                    infoFiltered: "(disaring dari _MAX_ total data)",
                    zeroRecords: "Tidak ada riwayat yang cocok",
                    emptyTable: "Belum ada riwayat buku yang dikembalikan",
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
