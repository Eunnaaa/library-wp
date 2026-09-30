<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Bukti Reservasi Booking - E-Library UNM</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #ffffff;
            margin: 0;
            padding: 15px 25px;
            color: #1e293b;
            font-size: 10pt;
            line-height: 1.4;
        }

        .header-kop {
            text-align: center;
            border-bottom: 3px double #1e293b;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }

        .header-kop h2 {
            margin: 0;
            font-size: 15pt;
            color: #0f172a;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .header-kop h4 {
            margin: 3px 0 0 0;
            font-size: 11pt;
            color: #2563eb;
            font-weight: bold;
        }

        .header-kop p {
            margin: 4px 0 0 0;
            font-size: 8.5pt;
            color: #64748b;
        }

        .ticket-badge {
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            border-left: 5px solid #2563eb;
            padding: 10px 14px;
            margin-bottom: 18px;
        }

        .ticket-title {
            font-size: 11pt;
            font-weight: bold;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 4px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 4px 8px;
            font-size: 9pt;
            vertical-align: top;
        }

        .info-table .label {
            color: #64748b;
            width: 22%;
            font-weight: bold;
        }

        .info-table .val {
            color: #0f172a;
            width: 28%;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            margin-bottom: 20px;
        }

        .data-table th {
            background-color: #1e3a8a;
            color: #ffffff;
            font-weight: bold;
            font-size: 9pt;
            padding: 8px 10px;
            text-align: left;
            border: 1px solid #1e3a8a;
        }

        .data-table td {
            padding: 7px 10px;
            font-size: 8.5pt;
            border: 1px solid #e2e8f0;
        }

        .data-table tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .center {
            text-align: center;
        }

        .notice-box {
            background-color: #fffbeb;
            border: 1px solid #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 10px 14px;
            margin-top: 15px;
            font-size: 8.5pt;
            color: #92400e;
        }

        .notice-box strong {
            display: block;
            margin-bottom: 4px;
            color: #78350f;
        }

        .notice-box ol {
            margin: 0;
            padding-left: 18px;
        }

        .notice-box li {
            margin-bottom: 2px;
        }

        .signature-table {
            width: 100%;
            margin-top: 25px;
            border-collapse: collapse;
        }

        .signature-table td {
            vertical-align: top;
            font-size: 9pt;
        }
    </style>
</head>

<body>
    <div class="header-kop">
        <h2>UNIVERSITAS NUSA MANDIRI</h2>
        <h4>UNIT PELAKSANA TEKNIS (UPT) PERPUSTAKAAN DIGITAL</h4>
        <p>Jl. Margonda Raya No. 545, Depok, Jawa Barat | Website: unm.ac.id | Email: perpustakaan@nusamandiri.ac.id</p>
    </div>

    <div class="ticket-badge">
        <div class="ticket-title">Tanda Bukti Reservasi Sirkulasi Buku</div>
        <table class="info-table">
            <tr>
                <td class="label">Kode Reservasi:</td>
                <td class="val"><strong style="color: #2563eb; font-size: 11pt;">{{ $data_booking[0]->id_booking }}</strong></td>
                <td class="label">Nama Anggota:</td>
                <td class="val"><strong>{{ $data_booking[0]->anggota->nama ?? '-' }}</strong></td>
            </tr>
            <tr>
                <td class="label">Waktu Booking:</td>
                <td class="val">{{ date('d F Y, H:i', strtotime($data_booking[0]->tgl_booking)) }} WIB</td>
                <td class="label">Email Anggota:</td>
                <td class="val">{{ $data_booking[0]->anggota->email ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Batas Ambil:</td>
                <td class="val" colspan="3">
                    <strong style="color: #dc2626;">{{ date('d F Y, H:i', strtotime($data_booking[0]->batas_ambil)) }} WIB</strong>
                    <span style="color: #64748b; font-size: 8pt;"> (Masa berlaku 1x24 jam)</span>
                </td>
            </tr>
        </table>
    </div>

    <div style="font-size: 9.5pt; font-weight: bold; color: #0f172a; margin-bottom: 6px;">
        Daftar Buku Yang Direservasi:
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th class="center" style="width: 25px;">#</th>
                <th style="width: 38%;">Judul Buku</th>
                <th style="width: 18%;">Kategori</th>
                <th style="width: 20%;">Pengarang</th>
                <th style="width: 14%;">Penerbit</th>
                <th class="center" style="width: 10%;">Tahun</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($data_booking as $booking)
                @foreach ($booking->booking_detail as $detail)
                    <tr>
                        <td class="center">{{ $no++ }}</td>
                        <td>
                            <strong>{{ $detail->buku->judul_buku ?? 'Buku Tidak Tersedia' }}</strong>
                            <div style="color: #64748b; font-size: 7.5pt;">ISBN: {{ $detail->buku->isbn ?? '-' }}</div>
                        </td>
                        <td>{{ $detail->buku->kategori->nama_kategori ?? '-' }}</td>
                        <td>{{ $detail->buku->pengarang ?? '-' }}</td>
                        <td>{{ $detail->buku->penerbit ?? '-' }}</td>
                        <td class="center">{{ $detail->buku->tahun_terbit ?? '-' }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    <div class="notice-box">
        <strong>Ketentuan Pengambilan Buku:</strong>
        <ol>
            <li>Bawa dan tunjukkan lembar bukti reservasi ini (cetak atau versi digital pada smartphone) kepada petugas loket sirkulasi perpustakaan UNM.</li>
            <li>Reservasi hanya berlaku maksimal 1 x 24 jam sejak pemesanan dibuat. Lewat dari batas waktu, sistem otomatis membatalkan pesanan dan mengembalikan stok.</li>
            <li>Tarif denda keterlambatan dan durasi masa pinjam dikonfirmasi oleh petugas saat penyerahan fisik buku.</li>
        </ol>
    </div>

    <table class="signature-table">
        <tr>
            <td style="width: 50%; text-align: center;">
                <p style="margin: 0; color: #64748b;">Anggota Peminjam,</p>
                <div style="height: 55px;"></div>
                <p style="margin: 0; font-weight: bold; border-top: 1px dotted #cbd5e1; display: inline-block; padding-top: 4px; min-width: 160px;">
                    ( {{ $data_booking[0]->anggota->nama ?? 'Mahasiswa / Anggota' }} )
                </p>
            </td>
            <td style="width: 50%; text-align: center;">
                <p style="margin: 0; color: #64748b;">Petugas Sirkulasi Perpustakaan,</p>
                <div style="height: 55px;"></div>
                <p style="margin: 0; font-weight: bold; border-top: 1px dotted #cbd5e1; display: inline-block; padding-top: 4px; min-width: 160px;">
                    ( Staf Perpustakaan UNM )
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
