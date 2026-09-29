<footer class="footer mt-auto" style="background: #0f172a; color: #94a3b8; border-top: 1px solid rgba(255, 255, 255, 0.08);">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-5 mb-4 mb-lg-0">
                <div class="d-flex align-items-center mb-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mr-2 shadow-sm" style="width: 38px; height: 38px; background: linear-gradient(135deg, #2563eb, #38bdf8);">
                        <i class="fas fa-book-reader text-white"></i>
                    </div>
                    <h5 class="text-white font-weight-bold mb-0">E-Library Universitas Nusa Mandiri</h5>
                </div>
                <p class="small text-muted mb-3" style="line-height: 1.7;">
                    Sistem otomasi dan reservasi sirkulasi perpustakaan digital terintegrasi untuk civitas akademika. Memudahkan mahasiswa dan dosen dalam menelusuri koleksi literatur, modul ajar, dan referensi penelitian ilmiah.
                </p>
                <div class="d-flex text-muted small">
                    <span class="mr-3"><i class="fas fa-map-marker-alt text-primary mr-1"></i> Kampus UNM Margonda / Kramat 98</span>
                </div>
            </div>

            <div class="col-6 col-lg-3 mb-4 mb-lg-0">
                <h6 class="text-white font-weight-bold text-uppercase mb-3" style="font-size: 0.85rem; letter-spacing: 0.05em;">Layanan & Navigasi</h6>
                <ul class="list-unstyled small mb-0" style="line-height: 2.2;">
                    <li><a href="{{ url('/') }}" class="text-muted text-decoration-none hover-white"><i class="fas fa-chevron-right mr-1 text-primary" style="font-size: 0.65rem;"></i> Katalog Buku Lengkap</a></li>
                    @auth
                        @if(Auth::user()->role_id == 2)
                            <li><a href="{{ route('member.dataBooking') }}" class="text-muted text-decoration-none"><i class="fas fa-chevron-right mr-1 text-primary" style="font-size: 0.65rem;"></i> Riwayat Booking Aktif</a></li>
                            <li><a href="{{ route('member.dataKeranjang') }}" class="text-muted text-decoration-none"><i class="fas fa-chevron-right mr-1 text-primary" style="font-size: 0.65rem;"></i> Keranjang Peminjaman</a></li>
                        @endif
                    @else
                        <li><a href="{{ route('login') }}" class="text-muted text-decoration-none"><i class="fas fa-chevron-right mr-1 text-primary" style="font-size: 0.65rem;"></i> Masuk Akun Anggota</a></li>
                        <li><a href="{{ route('register') }}" class="text-muted text-decoration-none"><i class="fas fa-chevron-right mr-1 text-primary" style="font-size: 0.65rem;"></i> Pendaftaran Anggota Baru</a></li>
                    @endauth
                </ul>
            </div>

            <div class="col-6 col-lg-4">
                <h6 class="text-white font-weight-bold text-uppercase mb-3" style="font-size: 0.85rem; letter-spacing: 0.05em;">Jam Operasional Perpustakaan</h6>
                <div class="p-3 rounded small" style="background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(255, 255, 255, 0.06);">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-light">Senin - Kamis</span>
                        <strong class="text-white">08:00 - 16:30 WIB</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-light">Jumat</span>
                        <strong class="text-white">08:00 - 16:00 WIB</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-light">Sabtu (Layanan Terbatas)</span>
                        <strong class="text-warning">08:30 - 12:00 WIB</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-3 text-center small border-top" style="border-color: rgba(255, 255, 255, 0.06) !important; background: #090e17;">
        <div class="container d-flex flex-column flex-sm-row justify-content-between align-items-center">
            <span class="text-muted mb-2 mb-sm-0">
                &copy; {{ date('Y') }} <strong>E-Library UNM</strong>. All Rights Reserved. Fakultas Teknologi Informasi.
            </span>
            <span class="badge badge-secondary px-3 py-1" style="background: rgba(255, 255, 255, 0.1); color: #94a3b8; font-weight: 500;">
                Sistem Informasi Perpustakaan v2.0
            </span>
        </div>
    </div>
</footer>
