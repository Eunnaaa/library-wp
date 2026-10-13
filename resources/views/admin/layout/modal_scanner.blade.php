<!-- Modal Scanner QR Code Pengambilan Buku -->
<div class="modal fade" id="modalScannerQr" tabindex="-1" role="dialog" aria-labelledby="modalScannerQrLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content shadow-lg border-0" style="border-radius: 16px; overflow: hidden;">
            <div class="modal-header py-3 px-4 text-white" style="background: linear-gradient(135deg, #1b1008 0%, #2c1a10 50%, #3d2517 100%); border-bottom: 2px solid #c59b27;">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 38px; height: 38px; background: rgba(197, 155, 39, 0.25); color: #e9c46a; border: 1px solid rgba(197, 155, 39, 0.4);">
                        <i class="fas fa-camera"></i>
                    </div>
                    <div>
                        <h5 class="modal-title font-weight-bold mb-0 text-white" id="modalScannerQrLabel" style="letter-spacing: -0.01em;">
                            Pemindai QR Code Loket Peminjaman
                        </h5>
                        <small style="color: #e5dacd;">Arahkan kamera ke QR Code bukti booking, unggah gambar QR, atau masukkan kode</small>
                    </div>
                </div>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity: 0.85;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body p-4" style="background: #fdfbf7;">
                <!-- Camera Controls & Viewport -->
                <div class="card border-0 shadow-sm mb-3" style="border-radius: 12px; border: 1px solid #e8e2d4 !important; background: #ffffff;">
                    <div class="card-body p-3">
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center mb-3">
                            <div class="d-flex align-items-center mb-2 mb-sm-0">
                                <span class="badge badge-pill badge-primary mr-2 px-3 py-1 font-weight-bold" id="scanner-status-badge">
                                    <i class="fas fa-video mr-1"></i> Kamera Siap
                                </span>
                                <small class="text-muted d-none d-md-inline" id="camera-hint-text">Mempersiapkan perangkat webcam...</small>
                            </div>
                            <div class="d-flex align-items-center">
                                <select id="qr-camera-select" class="custom-select custom-select-sm mr-2" style="max-width: 200px; border-radius: 8px;">
                                    <option value="">Memuat kamera...</option>
                                </select>
                                <button type="button" id="btn-toggle-camera" class="btn btn-sm btn-outline-secondary font-weight-bold px-3" style="border-radius: 8px;">
                                    <i class="fas fa-sync-alt mr-1"></i> Ganti
                                </button>
                            </div>
                        </div>

                        <!-- Scanner Viewport Container -->
                        <div id="qr-scanner-wrapper" class="position-relative rounded overflow-hidden text-center" style="background: #0f172a; min-height: 280px; border: 2px dashed rgba(197, 155, 39, 0.5);">
                            <div id="qr-video-reader" style="width: 100%;"></div>

                            <!-- Initial Camera Overlay Hint -->
                            <div id="scanner-placeholder" class="py-5 px-3 text-white d-flex flex-column align-items-center justify-content-center" style="min-height: 280px;">
                                <div class="rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px; background: rgba(255, 255, 255, 0.1); border: 2px dashed #e9c46a;">
                                    <i class="fas fa-qrcode fa-2x text-warning"></i>
                                </div>
                                <h6 class="font-weight-bold mb-1" id="scanner-placeholder-title">Kamera Sedang Memuat...</h6>
                                <p class="small text-muted mb-3" id="scanner-placeholder-desc" style="max-width: 400px;">
                                    Izinkan akses webcam pada peramban Anda saat diminta untuk mulai memindai QR Code.
                                </p>
                                <button type="button" id="btn-start-scanner" class="btn btn-warning btn-sm font-weight-bold px-4 shadow-sm" style="border-radius: 8px;">
                                    <i class="fas fa-play mr-1"></i> Aktifkan Kamera
                                </button>
                            </div>
                        </div>

                        <!-- Alternative 1: Upload File / Screenshot QR Code -->
                        <div class="mt-3 pt-3 border-top" style="border-color: #efe8dc !important;">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <label class="small font-weight-bold text-muted text-uppercase mb-0">
                                    <i class="fas fa-file-image mr-1 text-primary"></i> Pindai Dari File Gambar / Screenshot:
                                </label>
                                <span class="badge badge-light text-muted">PNG / JPG / WEBP</span>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="qr-file-input" accept="image/*">
                                <label class="custom-file-label text-truncate" for="qr-file-input" id="qr-file-label" style="border-radius: 8px;">Pilih atau drag file foto QR Code...</label>
                            </div>
                        </div>

                        <!-- Alternative 2: Manual Code Input -->
                        <div class="mt-3 pt-2">
                            <label class="small font-weight-bold text-muted text-uppercase mb-1">
                                <i class="fas fa-keyboard mr-1 text-secondary"></i> Atau Input Manual Kode Booking:
                            </label>
                            <div class="input-group">
                                <input type="text" id="manual-code-input" class="form-control form-control-sm font-weight-bold" placeholder="Contoh: B261013001" style="border-radius: 8px 0 0 8px; letter-spacing: 0.05em; text-transform: uppercase;">
                                <div class="input-group-append">
                                    <button class="btn btn-primary btn-sm px-3 font-weight-bold" type="button" id="btn-submit-manual-code" style="border-radius: 0 8px 8px 0;">
                                        <i class="fas fa-search mr-1"></i> Periksa Kode
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Verification Result Container (Populated via AJAX) -->
                <div id="qr-result-container" class="d-none">
                    <!-- Dynamic Content Injected by JS -->
                </div>
            </div>

            <div class="modal-footer py-2 px-4 bg-light border-top d-flex justify-content-between">
                <small class="text-muted"><i class="fas fa-shield-alt mr-1 text-success"></i> Verifikasi Loket Resmi E-Library UNM</small>
                <button type="button" class="btn btn-secondary btn-sm px-4 font-weight-bold" data-dismiss="modal" style="border-radius: 8px;">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        var html5QrCode = null;
        var currentCameraId = null;
        var isScanning = false;
        var camerasList = [];

        function playScanBeep() {
            try {
                var AudioContextClass = window.AudioContext || window.webkitAudioContext;
                if (!AudioContextClass) return;
                var audioCtx = new AudioContextClass();
                var osc = audioCtx.createOscillator();
                var gain = audioCtx.createGain();
                osc.type = "sine";
                osc.frequency.value = 920;
                gain.gain.value = 0.25;
                osc.connect(gain);
                gain.connect(audioCtx.destination);
                osc.start();
                setTimeout(function() {
                    osc.stop();
                    audioCtx.close();
                }, 160);
            } catch(e) {}
        }

        function requestCameraPermissionAndStart() {
            if (typeof Html5Qrcode === 'undefined') {
                showCameraError('Library scanner QR Code belum siap. Pastikan koneksi internet/file aset termuat dengan benar.', 'Library Belum Siap');
                return;
            }

            // Check Secure Context
            var isLocalhost = window.location.hostname === 'localhost' || window.location.hostname === '127.0.0.1';
            var isHttps = window.location.protocol === 'https:';
            if (!isLocalhost && !isHttps) {
                showCameraError(
                    'Browser membatasi webcam jika dibuka via IP jaringan tanpa HTTPS.<br>' +
                    'Silakan akses melalui <code>http://127.0.0.1:8000</code> atau <code>http://localhost:8000</code>, ' +
                    'atau gunakan opsi <b>Unggah File Gambar QR</b> / <b>Input Manual</b>.',
                    'Koneksi Non-Aman Terdeteksi'
                );
                return;
            }

            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                showCameraError(
                    'Peramban ini tidak mendukung akses webcam langsung.<br>' +
                    'Silakan gunakan opsi <b>Unggah File Gambar QR</b> atau <b>Input Manual Kode Booking</b> di bawah.',
                    'Peramban Tidak Mendukung'
                );
                return;
            }

            // Update UI state
            $('#scanner-placeholder').removeClass('d-none');
            $('#scanner-status-badge').removeClass('badge-secondary badge-success badge-danger')
                .addClass('badge-warning')
                .html('<i class="fas fa-spinner fa-spin mr-1"></i> Meminta Izin Kamera...');
            $('#camera-hint-text').text('Menghubungkan ke webcam...');
            $('#scanner-placeholder-title').text('Menghubungkan ke Webcam...');
            $('#scanner-placeholder-desc').html('Jika muncul pop-up izin peramban, klik tombol <b>Izinkan (Allow)</b>.');
            $('#btn-start-scanner').prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Menghubungkan...');

            // Directly call getUserMedia to trigger browser native permission dialog
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(function(stream) {
                    // Release the temporary stream tracks immediately
                    stream.getTracks().forEach(function(track) {
                        try { track.stop(); } catch(e) {}
                    });

                    // Now permission is granted, query available cameras
                    return Html5Qrcode.getCameras();
                })
                .then(function(devices) {
                    camerasList = devices || [];
                    var $select = $('#qr-camera-select');
                    $select.empty();

                    if (camerasList.length > 0) {
                        camerasList.forEach(function(cam, i) {
                            var label = cam.label || ('Kamera ' + (i + 1));
                            $select.append('<option value="' + cam.id + '">' + label + '</option>');
                        });
                        currentCameraId = camerasList[0].id;
                        $select.val(currentCameraId);
                        startScanner(currentCameraId);
                    } else {
                        // Fallback: try starting with environment/user facing mode
                        startScanner({ facingMode: "environment" });
                    }
                })
                .catch(function(err) {
                    console.warn('Camera access error:', err);
                    handleCameraError(err);
                });
        }

        function handleCameraError(err) {
            isScanning = false;
            var errName = err ? (err.name || err.toString()) : '';
            var title = 'Kendala Akses Kamera';
            var message = '';

            if (errName === 'NotAllowedError' || errName === 'PermissionDeniedError') {
                title = 'Izin Akses Kamera Ditolak';
                message = 'Akses kamera diblokir oleh pengaturan browser Anda.<br>' +
                          '<div class="text-left mt-2 p-2 bg-dark rounded small">' +
                          '<b>Cara mengaktifkan izin:</b><br>' +
                          '1. Klik ikon <b>Gembok (🔒)</b> atau <b>Kamera</b> di sebelah kiri kolom URL peramban (' + window.location.hostname + ')<br>' +
                          '2. Ubah izin <b>Camera</b> menjadi <b>Allow (Izinkan)</b><br>' +
                          '3. Klik tombol <b>Coba Aktifkan Lagi</b> di bawah.' +
                          '</div>';
            } else if (errName === 'NotFoundError' || errName === 'DevicesNotFoundError') {
                title = 'Kamera Tidak Ditemukan';
                message = 'Tidak ada perangkat kamera/webcam yang terdeteksi pada perangkat ini.<br>' +
                          'Gunakan opsi <b>Unggah File Gambar QR</b> atau <b>Input Manual</b>.';
            } else if (errName === 'NotReadableError' || errName === 'TrackStartError') {
                title = 'Kamera Sedang Digunakan';
                message = 'Kamera mungkin sedang digunakan oleh aplikasi lain (Zoom, Teams, Google Meet, dll.).<br>' +
                          'Silakan tutup aplikasi tersebut lalu klik tombol di bawah.';
            } else {
                title = 'Gagal Mengakses Kamera';
                message = 'Terjadi kesalahan saat memuat webcam (' + (err.message || errName || 'Unknown') + ').<br>' +
                          'Gunakan opsi <b>Unggah File Gambar QR</b> atau <b>Input Manual</b>.';
            }

            showCameraError(message, title);
        }

        function showCameraError(msg, title) {
            $('#scanner-status-badge').removeClass('badge-secondary badge-success badge-warning')
                .addClass('badge-danger')
                .html('<i class="fas fa-exclamation-triangle mr-1"></i> Kamera Tidak Tersedia');
            $('#camera-hint-text').html('<span class="text-danger">Kamera gagal diakses. Gunakan upload gambar atau input manual.</span>');

            $('#scanner-placeholder').removeClass('d-none').html(
                '<div class="p-3 text-center">' +
                '<div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 58px; height: 58px; background: rgba(239, 68, 68, 0.2); border: 2px solid #ef4444;">' +
                '<i class="fas fa-video-slash fa-2x text-danger"></i>' +
                '</div>' +
                '<h6 class="font-weight-bold text-white mb-2">' + (title || 'Akses Kamera Terkendala') + '</h6>' +
                '<div class="small text-white-50 mb-3 mx-auto" style="max-width: 440px; line-height: 1.5;">' + msg + '</div>' +
                '<div class="d-flex justify-content-center flex-wrap">' +
                '<button type="button" class="btn btn-warning btn-sm font-weight-bold px-3 mr-2 mb-2 btn-retry-camera" style="border-radius: 8px;">' +
                '<i class="fas fa-redo mr-1"></i> Coba Aktifkan Lagi' +
                '</button>' +
                '<button type="button" class="btn btn-outline-light btn-sm font-weight-bold px-3 mb-2 btn-focus-manual" style="border-radius: 8px;">' +
                '<i class="fas fa-keyboard mr-1"></i> Input Kode Manual' +
                '</button>' +
                '</div>' +
                '</div>'
            );
        }

        function startScanner(cameraConfig) {
            if (!cameraConfig) return;
            if (isScanning) {
                stopScanner();
            }

            if (!html5QrCode) {
                html5QrCode = new Html5Qrcode("qr-video-reader");
            }

            $('#scanner-placeholder').addClass('d-none');
            $('#scanner-status-badge').removeClass('badge-secondary badge-danger badge-warning')
                .addClass('badge-success')
                .html('<i class="fas fa-spinner fa-spin mr-1"></i> Membuka Stream...');

            var scanConfig = {
                fps: 15,
                qrbox: function(viewfinderWidth, viewfinderHeight) {
                    var minEdge = Math.min(viewfinderWidth, viewfinderHeight);
                    var qrboxSize = Math.floor(minEdge * 0.7);
                    return {
                        width: Math.max(180, qrboxSize),
                        height: Math.max(180, qrboxSize)
                    };
                },
                aspectRatio: 1.333334
            };

            html5QrCode.start(
                cameraConfig,
                scanConfig,
                function(decodedText, decodedResult) {
                    playScanBeep();
                    stopScanner();
                    $('#manual-code-input').val(decodedText);
                    verifikasiCode(decodedText);
                },
                function(errorMessage) {
                    // Ongoing search, quiet
                }
            ).then(function() {
                isScanning = true;
                $('#scanner-placeholder').addClass('d-none');
                $('#scanner-status-badge').removeClass('badge-primary badge-secondary badge-warning badge-danger')
                    .addClass('badge-success')
                    .html('<i class="fas fa-video mr-1"></i> Kamera Aktif & Memindai');
                $('#camera-hint-text').text('Arahkan kamera ke QR Code bukti booking.');
            }).catch(function(err) {
                console.warn('Failed to start scanner with config:', cameraConfig, err);
                isScanning = false;
                // If failed with specific cameraId, try with facingMode: "user"
                if (typeof cameraConfig === 'string') {
                    html5QrCode.start({ facingMode: "user" }, scanConfig, function(decodedText) {
                        playScanBeep();
                        stopScanner();
                        $('#manual-code-input').val(decodedText);
                        verifikasiCode(decodedText);
                    }, function() {}).then(function() {
                        isScanning = true;
                        $('#scanner-placeholder').addClass('d-none');
                        $('#scanner-status-badge').removeClass('badge-secondary badge-danger badge-warning')
                            .addClass('badge-success')
                            .html('<i class="fas fa-video mr-1"></i> Kamera Aktif & Memindai');
                    }).catch(function(retryErr) {
                        handleCameraError(retryErr);
                    });
                } else {
                    handleCameraError(err);
                }
            });
        }

        function stopScanner() {
            if (html5QrCode && isScanning) {
                try {
                    html5QrCode.stop().then(function() {
                        isScanning = false;
                        $('#scanner-status-badge').removeClass('badge-success badge-warning badge-danger')
                            .addClass('badge-secondary')
                            .html('<i class="fas fa-video-slash mr-1"></i> Kamera Nonaktif');
                    }).catch(function(err) {
                        isScanning = false;
                    });
                } catch(e) {
                    isScanning = false;
                }
            } else {
                isScanning = false;
            }
        }

        function verifikasiCode(code) {
            code = $.trim(code);
            if (!code) {
                toastr.warning('Masukkan kode booking terlebih dahulu.');
                return;
            }

            var $container = $('#qr-result-container');
            $container.removeClass('d-none').html(
                '<div class="text-center py-4 bg-white rounded border my-2">' +
                '<i class="fas fa-spinner fa-spin fa-2x text-primary mb-2"></i>' +
                '<div class="font-weight-bold text-dark">Memverifikasi Kode: <span class="text-primary">' + code + '</span>...</div>' +
                '</div>'
            );

            // Auto-scroll ke hasil
            $container[0].scrollIntoView({ behavior: 'smooth', block: 'nearest' });

            var baseUrl = window.APP_URL || '';
            $.ajax({
                url: baseUrl + '/admin/transaksi/booking/verifikasi-qr',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    code: code
                },
                success: function(res) {
                    renderResult(res);
                },
                error: function(xhr) {
                    var msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Kode booking tidak ditemukan atau terjadi kesalahan.';
                    renderError(msg, code);
                }
            });
        }

        function renderResult(res) {
            var $container = $('#qr-result-container');
            var isValid = res.status === 'valid';
            var isExpired = res.status === 'expired';
            var isAlready = res.status === 'already_processed';
            var baseUrl = window.APP_URL || '';

            var badgeHtml = '';
            var bannerBg = '';
            if (isValid) {
                badgeHtml = '<span class="badge badge-success px-3 py-1 font-weight-bold"><i class="fas fa-check-circle mr-1"></i> SIAP DIAMBIL (VALID)</span>';
                bannerBg = 'linear-gradient(135deg, #14532d, #166534)';
            } else if (isExpired) {
                badgeHtml = '<span class="badge badge-danger px-3 py-1 font-weight-bold"><i class="fas fa-clock mr-1"></i> KEDALUWARSA (LEWAT 1x24 JAM)</span>';
                bannerBg = 'linear-gradient(135deg, #7f1d1d, #991b1b)';
            } else if (isAlready) {
                badgeHtml = '<span class="badge badge-info px-3 py-1 font-weight-bold"><i class="fas fa-history mr-1"></i> SUDAH PERNAH DIAMBIL</span>';
                bannerBg = 'linear-gradient(135deg, #1e3a8a, #1e40af)';
            }

            var html = '';
            html += '<div class="card border-0 shadow-sm mb-3" style="border-radius: 14px; overflow: hidden; border: 1px solid #e8e2d4 !important;">';
            html += '  <div class="card-header text-white p-3 d-flex justify-content-between align-items-center" style="background: ' + bannerBg + ';">';
            html += '    <div>';
            html += '      <strong class="d-block" style="font-size: 1.1rem; letter-spacing: 0.05em;"><i class="fas fa-receipt mr-1"></i> ' + res.code + '</strong>';
            html += '      <small class="text-white-50">' + res.message + '</small>';
            html += '    </div>';
            html += '    <div>' + badgeHtml + '</div>';
            html += '  </div>';

            html += '  <div class="card-body p-3 bg-white">';
            if (isValid || isExpired) {
                html += '    <div class="row mb-3 pb-3 border-bottom">';
                html += '      <div class="col-sm-6 mb-2 mb-sm-0 d-flex align-items-center">';
                html += '        <img src="' + res.anggota.image_url + '" class="rounded-circle mr-3 border shadow-sm" width="52" height="52" style="object-fit: cover;" onerror="this.src=\'' + baseUrl + '/assets/dist/img/default-150x150.png\';">';
                html += '        <div>';
                html += '          <span class="text-muted small font-weight-bold text-uppercase d-block">Anggota Pemesan</span>';
                html += '          <h6 class="font-weight-bold text-dark mb-0">' + res.anggota.nama + '</h6>';
                html += '          <small class="text-muted">' + res.anggota.email + '</small>';
                html += '        </div>';
                html += '      </div>';
                html += '      <div class="col-sm-6 text-sm-right">';
                html += '        <span class="text-muted small font-weight-bold text-uppercase d-block">Waktu Reservasi</span>';
                html += '        <strong class="text-dark d-block">' + res.booking.tgl_booking + ' WIB</strong>';
                html += '        <small class="text-danger font-weight-bold"><i class="fas fa-hourglass-half mr-1"></i> Batas: ' + res.booking.batas_ambil + ' (' + res.booking.sisa_waktu + ')</small>';
                html += '      </div>';
                html += '    </div>';

                html += '    <h6 class="font-weight-bold text-dark mb-2"><i class="fas fa-book text-primary mr-1"></i> Rincian Buku (' + res.total_buku + ' Judul):</h6>';
                html += '    <div class="table-responsive border rounded mb-3">';
                html += '      <table class="table table-sm table-hover mb-0">';
                html += '        <thead class="bg-light"><tr><th style="width: 50px;">Cover</th><th>Judul Buku</th><th>Kategori</th><th>Pengarang</th><th class="text-center" style="width: 90px;">Lama Pinjam</th><th class="text-center" style="width: 100px;">Tarif Denda</th></tr></thead>';
                html += '        <tbody>';

                res.buku.forEach(function(b, idx) {
                    html += '      <tr>';
                    html += '        <td><img src="' + b.cover_url + '" class="rounded border" width="38" height="54" style="object-fit: cover;"></td>';
                    html += '        <td><strong class="text-dark d-block">' + b.judul_buku + '</strong><small class="text-muted">ISBN: ' + b.isbn + '</small></td>';
                    html += '        <td><span class="badge badge-info">' + b.kategori + '</span></td>';
                    html += '        <td><small>' + b.pengarang + '</small></td>';
                    html += '        <td class="text-center"><input type="number" name="lama[' + b.id_buku + ']" value="7" min="1" max="30" class="form-control form-control-sm text-center font-weight-bold form-lama-pinjam" style="border-radius: 6px;"></td>';
                    html += '        <td class="text-center"><input type="number" name="denda[' + b.id_buku + ']" value="1000" min="0" step="500" class="form-control form-control-sm text-center font-weight-bold form-denda-pinjam" style="border-radius: 6px;"></td>';
                    html += '      </tr>';
                });

                html += '        </tbody>';
                html += '      </table>';
                html += '    </div>';

                if (isValid) {
                    html += '    <div class="d-flex justify-content-between align-items-center pt-2">';
                    html += '      <button type="button" class="btn btn-outline-secondary btn-sm font-weight-bold btn-scan-lagi" style="border-radius: 8px;">';
                    html += '        <i class="fas fa-camera mr-1"></i> Scan QR Lain';
                    html += '      </button>';
                    html += '      <button type="button" class="btn btn-success font-weight-bold px-4 shadow-sm btn-proses-serah" data-code="' + res.code + '" style="border-radius: 8px;">';
                    html += '        <i class="fas fa-hand-holding mr-1"></i> Konfirmasi Penyerahan Buku (Proses Pinjam)';
                    html += '      </button>';
                    html += '    </div>';
                } else {
                    html += '    <div class="alert alert-danger mb-0 small"><i class="fas fa-exclamation-triangle mr-1"></i> Booking ini sudah melewati batas waktu 1x24 jam. Stok buku telah/dapat dibatalkan oleh admin di menu daftar booking.</div>';
                }
            } else if (isAlready) {
                html += '    <div class="alert alert-info mb-0 small"><i class="fas fa-info-circle mr-1"></i> Nomor Transaksi Pinjam: <strong>' + (res.no_pinjam || '-') + '</strong>. Buku sudah berada di tangan anggota.</div>';
            }
            html += '  </div>';
            html += '</div>';

            $container.html(html);
        }

        function renderError(message, code) {
            var html = '';
            html += '<div class="alert alert-danger shadow-sm border-0 d-flex align-items-center mb-0 p-3" style="border-radius: 12px;">';
            html += '  <i class="fas fa-times-circle fa-2x mr-3 text-danger"></i>';
            html += '  <div class="flex-grow-1">';
            html += '    <h6 class="font-weight-bold mb-1">Verifikasi Gagal</h6>';
            html += '    <div class="small">' + message + '</div>';
            html += '  </div>';
            html += '  <button type="button" class="btn btn-outline-danger btn-sm font-weight-bold ml-2 btn-scan-lagi" style="border-radius: 8px;">Coba Lagi</button>';
            html += '</div>';
            $('#qr-result-container').html(html);
        }

        // Event Listeners
        $('#modalScannerQr').on('shown.bs.modal', function() {
            requestCameraPermissionAndStart();
        });

        $('#modalScannerQr').on('hidden.bs.modal', function() {
            stopScanner();
            $('#qr-result-container').addClass('d-none').empty();
            $('#manual-code-input').val('');
            $('#qr-file-input').val('');
            $('#qr-file-label').text('Pilih atau drag file foto QR Code...');
        });

        $(document).on('click', '#btn-start-scanner, .btn-retry-camera', function() {
            requestCameraPermissionAndStart();
        });

        $(document).on('click', '.btn-focus-manual', function() {
            $('#manual-code-input').focus();
        });

        $('#btn-toggle-camera').on('click', function() {
            var selected = $('#qr-camera-select').val();
            if (selected) {
                currentCameraId = selected;
                startScanner(selected);
            }
        });

        $('#qr-camera-select').on('change', function() {
            var selected = $(this).val();
            if (selected) {
                currentCameraId = selected;
                startScanner(selected);
            }
        });

        // Scan from Image File
        $('#qr-file-input').on('change', function(e) {
            var file = e.target.files[0];
            if (!file) return;

            $('#qr-file-label').text(file.name);

            if (!html5QrCode) {
                html5QrCode = new Html5Qrcode("qr-video-reader");
            }

            if (isScanning) {
                stopScanner();
            }

            toastr.info('Menganalisis gambar QR Code...');
            html5QrCode.scanFile(file, true)
                .then(function(decodedText) {
                    playScanBeep();
                    $('#manual-code-input').val(decodedText);
                    toastr.success('QR Code berhasil dibaca dari gambar!');
                    verifikasiCode(decodedText);
                })
                .catch(function(err) {
                    toastr.error('QR Code tidak dapat terbaca dari gambar ini. Pastikan gambar jelas dan memiliki QR Code bukti booking.');
                });
        });

        // Manual Code Input
        $('#btn-submit-manual-code').on('click', function() {
            var val = $('#manual-code-input').val();
            verifikasiCode(val);
        });

        $('#manual-code-input').on('keypress', function(e) {
            if (e.which === 13) {
                e.preventDefault();
                verifikasiCode($(this).val());
            }
        });

        $(document).on('click', '.btn-scan-lagi', function() {
            $('#qr-result-container').addClass('d-none').empty();
            $('#manual-code-input').val('');
            $('#qr-file-input').val('');
            $('#qr-file-label').text('Pilih atau drag file foto QR Code...');
            if (currentCameraId) {
                startScanner(currentCameraId);
            } else {
                requestCameraPermissionAndStart();
            }
        });

        // Process Borrow Loan Confirmation
        $(document).on('click', '.btn-proses-serah', function() {
            var $btn = $(this);
            var code = $btn.data('code');
            if (!code) return;

            var postData = {
                _token: $('meta[name="csrf-token"]').attr('content'),
                id_booking: code,
                lama: $('.form-lama-pinjam').first().val() ? [$('.form-lama-pinjam').first().val()] : [7],
                denda: $('.form-denda-pinjam').first().val() ? [$('.form-denda-pinjam').first().val()] : [1000]
            };

            // Dynamic arrays
            $('.form-lama-pinjam').each(function() {
                postData[$(this).attr('name')] = $(this).val();
            });
            $('.form-denda-pinjam').each(function() {
                postData[$(this).attr('name')] = $(this).val();
            });

            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Memproses Penyerahan...');

            var baseUrl = window.APP_URL || '';
            $.ajax({
                url: baseUrl + '/admin/transaksi/peminjaman',
                type: 'POST',
                data: postData,
                success: function(response) {
                    toastr.success(response.success || 'Buku berhasil diserahkan ke anggota dan peminjaman aktif tercatat!');
                    $('#qr-result-container').html(
                        '<div class="alert alert-success shadow-sm border-0 text-center py-4 my-2" style="border-radius: 12px;">' +
                        '<div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2 text-white bg-success" style="width: 50px; height: 50px;">' +
                        '<i class="fas fa-check fa-lg"></i>' +
                        '</div>' +
                        '<h5 class="font-weight-bold text-success mb-1">Transaksi Peminjaman Selesai!</h5>' +
                        '<p class="small text-muted mb-3">Fisik buku telah resmi diserahkan. Transaksi booking berhasil dikonversi ke peminjaman aktif.</p>' +
                        '<button type="button" class="btn btn-outline-success btn-sm px-4 font-weight-bold btn-scan-lagi" style="border-radius: 8px;">Scan QR Berikutnya</button>' +
                        '</div>'
                    );
                },
                error: function(xhr) {
                    $btn.prop('disabled', false).html('<i class="fas fa-hand-holding mr-1"></i> Konfirmasi Penyerahan Buku (Proses Pinjam)');
                    var err = (xhr.responseJSON && xhr.responseJSON.error) ? xhr.responseJSON.error : 'Gagal memproses peminjaman buku.';
                    toastr.error(err);
                }
            });
        });
    })();
</script>
