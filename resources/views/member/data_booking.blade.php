@extends('member.layout.main')

@section('title', 'Bukti Booking Reservasi')

@section('content')
<div class="container pt-4 pb-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm mb-4" style="border-radius: 16px; overflow: hidden; border: 1px solid #e8e2d4 !important; background: #ffffff;">
                <div class="card-header bg-white py-3 px-4 border-bottom">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center w-100">
                        <div class="mb-2 mb-sm-0">
                            <h4 class="font-weight-bold mb-0 text-dark">
                                <i class="fas fa-receipt text-primary mr-2"></i> Bukti Reservasi Peminjaman Buku
                            </h4>
                            <small class="text-muted">Tunjukkan tanda bukti ini kepada staf sirkulasi perpustakaan UNM.</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <button type="button" onclick="window.print()" class="btn btn-outline-secondary btn-sm font-weight-bold px-3 py-2 mr-2 shadow-sm d-none d-sm-inline-block" style="border-radius: 8px;">
                                <i class="fas fa-print mr-1"></i> Cetak Bukti
                            </button>
                            @if(isset($data_booking[0]))
                                <a href="{{ route('member.bookingPdf') }}" target="_blank" class="btn btn-danger btn-sm font-weight-bold px-3 py-2 shadow-sm" style="border-radius: 8px;">
                                    <i class="fas fa-file-pdf mr-1"></i> Unduh PDF
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    @forelse ($data_booking as $booking)
                        <!-- Alert Countdown Notice -->
                        <div class="alert border-0 shadow-sm mb-4 d-flex align-items-center" style="background: #fffbeb; border-left: 5px solid #f59e0b !important; border-radius: 12px; color: #92400e;">
                            <i class="fas fa-clock fa-2x mr-3 text-warning"></i>
                            <div>
                                <h6 class="font-weight-bold mb-1">Masa Berlaku Pengambilan Buku (1 x 24 Jam)</h6>
                                <p class="small mb-0">
                                    Batas waktu pengambilan fisik di perpustakaan adalah <strong>{{ date('d F Y, H:i', strtotime($booking->batas_ambil)) }} WIB</strong>. Lewat dari batas waktu, reservasi buku akan dibatalkan otomatis dan stok dikembalikan.
                                </p>
                            </div>
                        </div>

                        <!-- Ticket Details Card with QR Code -->
                        <div class="card border mb-4 shadow-sm" style="border-radius: 14px; background: #fdfbf7; border: 1px solid #e8e2d4 !important; border-left: 5px solid #8b4513 !important;">
                            <div class="card-body p-4">
                                <div class="row align-items-center">
                                    <!-- QR Code Column -->
                                    <div class="col-lg-3 col-md-4 text-center mb-3 mb-md-0 border-right pr-md-4">
                                        <div class="p-2 bg-white rounded border d-inline-block shadow-sm" style="border-color: #e8e2d4 !important;">
                                            {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(118)->margin(1)->generate($booking->id_booking) !!}
                                        </div>
                                        <div class="mt-2">
                                            <span class="badge badge-light border text-dark font-weight-bold px-2 py-1" style="font-size: 0.72rem; letter-spacing: 0.5px;">
                                                <i class="fas fa-qrcode mr-1 text-primary"></i> QR LOKET UNM
                                            </span>
                                        </div>
                                        <button type="button" class="btn btn-outline-primary btn-sm mt-2 py-1 px-2 font-weight-bold shadow-none" data-toggle="modal" data-target="#modalZoomQr{{ $booking->id }}" style="font-size: 0.75rem; border-radius: 6px;">
                                            <i class="fas fa-search-plus mr-1"></i> Perbesar QR
                                        </button>
                                    </div>

                                    <!-- Details Columns -->
                                    <div class="col-lg-9 col-md-8 pl-md-4">
                                        <div class="row align-items-center">
                                            <div class="col-sm-6 mb-3 border-bottom pb-2">
                                                <span class="text-muted d-block small font-weight-bold text-uppercase">Nomor Reservasi</span>
                                                <div class="d-flex align-items-center my-1">
                                                    <span class="font-weight-bold h5 text-primary mb-0 mr-2" style="letter-spacing: 0.05em;">{{ $booking->id_booking }}</span>
                                                    <button type="button" class="btn btn-sm btn-light border py-0 px-2 text-primary shadow-sm" onclick="navigator.clipboard.writeText('{{ $booking->id_booking }}'); toastr.success('Nomor reservasi disalin!');" title="Salin No. Reservasi" style="border-radius: 6px;">
                                                        <i class="far fa-copy"></i>
                                                    </button>
                                                </div>
                                                <small class="text-muted"><i class="fas fa-info-circle mr-1 text-secondary"></i>Tunjukkan kode atau QR ini ke petugas</small>
                                            </div>
                                            <div class="col-sm-6 mb-3 border-bottom pb-2">
                                                <span class="text-muted d-block small font-weight-bold text-uppercase">Nama Anggota</span>
                                                <strong class="text-dark d-block" style="font-size: 1.05rem;">{{ $booking->anggota->nama ?? '-' }}</strong>
                                                <small class="text-muted">{{ $booking->anggota->email ?? '' }}</small>
                                            </div>
                                            <div class="col-sm-6 mb-2">
                                                <span class="text-muted d-block small font-weight-bold text-uppercase">Waktu Booking</span>
                                                <strong class="text-dark">{{ date('d M Y, H:i', strtotime($booking->tgl_booking)) }} WIB</strong>
                                                <small class="text-muted d-block mt-1"><i class="fas fa-lock mr-1 text-warning"></i>Status: Terkunci & Siap Diambil</small>
                                            </div>
                                            <div class="col-sm-6 mb-2">
                                                <span class="text-muted d-block small font-weight-bold text-uppercase">Batas Akhir Pengambilan</span>
                                                <span class="badge badge-warning px-2 py-1 font-weight-bold d-inline-block">{{ date('d M Y, H:i', strtotime($booking->batas_ambil)) }} WIB</span>
                                                <div class="small text-danger font-weight-bold mt-1" id="countdown-timer" data-expire="{{ $booking->batas_ambil }}">
                                                    <i class="fas fa-stopwatch mr-1"></i> <span id="countdown-text">Menghitung...</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Zoom QR Code -->
                        <div class="modal fade" id="modalZoomQr{{ $booking->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
                                <div class="modal-content shadow-lg border-0" style="border-radius: 16px;">
                                    <div class="modal-header bg-white border-bottom py-3">
                                        <h6 class="modal-title font-weight-bold text-dark"><i class="fas fa-qrcode text-primary mr-2"></i> QR Code Reservasi</h6>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body text-center p-4">
                                        <div class="p-3 bg-white rounded border d-inline-block shadow-sm mb-3">
                                            {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(220)->margin(1)->generate($booking->id_booking) !!}
                                        </div>
                                        <h5 class="font-weight-bold text-primary mb-1">{{ $booking->id_booking }}</h5>
                                        <p class="small text-muted mb-0">Tunjukkan layar ini kepada petugas loket sirkulasi perpustakaan UNM untuk verifikasi.</p>
                                    </div>
                                    <div class="modal-footer bg-light border-top py-2 px-3 text-center d-block">
                                        <button type="button" class="btn btn-secondary btn-sm px-4 font-weight-bold" data-dismiss="modal" style="border-radius: 8px;">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Book list -->
                        <h6 class="font-weight-bold text-dark mb-3"><i class="fas fa-book text-primary mr-1"></i> Rincian Buku yang Dipesan ({{ $booking->booking_detail->count() }} Judul):</h6>
                        <div class="table-responsive rounded border mb-4 bg-white">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr class="bg-light">
                                        <th class="text-center" style="width: 50px;">#</th>
                                        <th style="width: 80px;">Cover</th>
                                        <th>Informasi Buku</th>
                                        <th>Kategori</th>
                                        <th>Pengarang / Penerbit</th>
                                        <th class="text-center">Tahun</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($booking->booking_detail as $detail)
                                        <tr>
                                            <td class="text-center font-weight-bold text-muted">{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="book-cover-thumb book-cover-thumb-sm">
                                                    <img src="{{ asset('storage/' . ($detail->buku?->image ?? 'cover-buku/book-default-cover.jpg')) }}"
                                                        alt="Cover Buku"
                                                        onerror="this.onerror=null; this.src='{{ asset('storage/cover-buku/book-default-cover.jpg') }}';">
                                                </div>
                                            </td>
                                            <td>
                                                <strong class="text-dark">{{ $detail->buku?->judul_buku ?? 'Buku Tidak Tersedia' }}</strong>
                                                <div class="small text-muted">ISBN: <code>{{ $detail->buku?->isbn ?? '-' }}</code></div>
                                            </td>
                                            <td><span class="badge badge-info">{{ $detail->buku?->kategori?->nama_kategori ?? '-' }}</span></td>
                                            <td class="small">
                                                <div><strong>{{ $detail->buku?->pengarang ?? '-' }}</strong></div>
                                                <div class="text-muted">{{ $detail->buku?->penerbit ?? '-' }}</div>
                                            </td>
                                            <td class="text-center font-weight-bold text-secondary">{{ $detail->buku?->tahun_terbit ?? '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px; background: #fdf4eb; border: 1px solid rgba(139, 69, 19, 0.15);">
                                <i class="fas fa-receipt fa-3x" style="color: #8b4513;"></i>
                            </div>
                            <h5 class="font-weight-bold text-dark">Tidak Ada Transaksi Booking Aktif</h5>
                            <p class="text-muted small mx-auto mb-3" style="max-width: 400px;">
                                Anda belum memiliki reservasi buku yang aktif saat ini. Silakan kunjungi katalog untuk meminjam buku.
                            </p>
                            <a href="{{ route('member.index') }}" class="btn btn-primary btn-sm px-4 font-weight-bold" style="border-radius: 8px;">
                                <i class="fas fa-book-open mr-1"></i> Buka Katalog Buku
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        var $timer = $('#countdown-timer');
        if ($timer.length) {
            var expireStr = $timer.data('expire');
            var expireDate = new Date(expireStr).getTime();

            function updateCountdown() {
                var now = new Date().getTime();
                var distance = expireDate - now;

                if (distance < 0) {
                    $('#countdown-text').html('<span class="text-danger font-weight-bold">Waktu Habis!</span>');
                    return;
                }

                var hours = Math.floor(distance / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                $('#countdown-text').text(hours + 'j ' + minutes + 'm ' + seconds + 'd');
            }

            updateCountdown();
            setInterval(updateCountdown, 1000);
        }
    });
</script>
@endpush

