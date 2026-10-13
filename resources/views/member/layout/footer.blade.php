<footer class="footer mt-auto" style="background: #1b1008; color: #d4c5b3; border-top: 2px solid #c59b27;">
    <div class="container-fluid px-3 px-md-4 py-5">
        <div class="row">
            <div class="col-lg-5 mb-4 mb-lg-0">
                <div class="d-flex align-items-center mb-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mr-2 shadow-sm" style="width: 38px; height: 38px; background: linear-gradient(135deg, #c59b27, #e9c46a); border: 1px solid #d4af37;">
                        <i class="fas fa-book-reader" style="color: #1b1008;"></i>
                    </div>
                    <h5 class="text-white font-weight-bold mb-0" style="letter-spacing: -0.02em;">E-Library Universitas Nusa Mandiri</h5>
                </div>
                <p class="small mb-3" style="line-height: 1.7; color: #c4b5a3;">
                    Sistem otomasi dan reservasi sirkulasi perpustakaan digital terintegrasi untuk civitas akademika. Memudahkan mahasiswa dan dosen dalam menelusuri koleksi literatur, modul ajar, dan referensi penelitian ilmiah.
                </p>
                <div class="d-flex small" style="color: #d4af37;">
                    <span class="mr-3"><i class="fas fa-map-marker-alt mr-1" style="color: #c59b27;"></i> Kampus UNM Margonda / Kramat 98</span>
                </div>
            </div>

            <div class="col-6 col-lg-3 mb-4 mb-lg-0">
                <h6 class="font-weight-bold text-uppercase mb-3" style="font-size: 0.85rem; letter-spacing: 0.05em; color: #e9c46a;">Layanan & Navigasi</h6>
                <ul class="list-unstyled small mb-0" style="line-height: 2.2;">
                    <li><a href="{{ url('/') }}" class="text-decoration-none" style="color: #c4b5a3;"><i class="fas fa-chevron-right mr-1" style="font-size: 0.65rem; color: #c59b27;"></i> Katalog Buku Lengkap</a></li>
                    @auth
                        @if(Auth::user()->role_id == 2)
                            <li><a href="{{ route('member.dataBooking') }}" class="text-decoration-none" style="color: #c4b5a3;"><i class="fas fa-chevron-right mr-1" style="font-size: 0.65rem; color: #c59b27;"></i> Riwayat Booking Aktif</a></li>
                            <li><a href="{{ route('member.dataKeranjang') }}" class="text-decoration-none" style="color: #c4b5a3;"><i class="fas fa-chevron-right mr-1" style="font-size: 0.65rem; color: #c59b27;"></i> Keranjang Peminjaman</a></li>
                        @endif
                    @else
                        <li><a href="{{ route('login') }}" class="text-decoration-none" style="color: #c4b5a3;"><i class="fas fa-chevron-right mr-1" style="font-size: 0.65rem; color: #c59b27;"></i> Masuk Akun Anggota</a></li>
                        <li><a href="{{ route('register') }}" class="text-decoration-none" style="color: #c4b5a3;"><i class="fas fa-chevron-right mr-1" style="font-size: 0.65rem; color: #c59b27;"></i> Pendaftaran Anggota Baru</a></li>
                    @endauth
                </ul>
            </div>

            <div class="col-6 col-lg-4">
                <h6 class="font-weight-bold text-uppercase mb-3" style="font-size: 0.85rem; letter-spacing: 0.05em; color: #e9c46a;">Jam Operasional Perpustakaan</h6>
                <div class="p-3 rounded small" style="background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(197, 155, 39, 0.25);">
                    <div class="d-flex justify-content-between mb-2">
                        <span style="color: #e5d8c3;">Senin - Kamis</span>
                        <strong class="text-white">08:00 - 16:30 WIB</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span style="color: #e5d8c3;">Jumat</span>
                        <strong class="text-white">08:00 - 16:00 WIB</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span style="color: #e5d8c3;">Sabtu (Layanan Terbatas)</span>
                        <strong style="color: #e9c46a;">08:30 - 12:00 WIB</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-3 text-center small border-top" style="border-color: rgba(197, 155, 39, 0.2) !important; background: #120a05;">
        <div class="container-fluid px-3 px-md-4 d-flex flex-column flex-sm-row justify-content-between align-items-center">
            <span class="mb-2 mb-sm-0" style="color: #a89a88;">
                &copy; {{ date('Y') }} <strong>E-Library UNM</strong>. All Rights Reserved. Fakultas Teknologi Informasi.
            </span>
            <span class="badge px-3 py-1 font-weight-bold" style="background: rgba(197, 155, 39, 0.15); color: #e9c46a; border: 1px solid rgba(197, 155, 39, 0.3);">
                Sistem Informasi Perpustakaan v2.0
            </span>
        </div>
    </div>
</footer>
