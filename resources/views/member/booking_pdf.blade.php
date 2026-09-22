<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Booking Buku - E-Library UNM</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #fff;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 18pt;
            color: #1a202c;
        }

        .header p {
            margin: 4px 0 0 0;
            font-size: 10pt;
            color: #4a5568;
        }

        .info {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .info th,
        .info td {
            padding: 8px 12px;
            text-align: left;
            border: 1px solid #ddd;
            font-size: 10pt;
        }

        .info th {
            background-color: #f7fafc;
            font-weight: bold;
            width: 25%;
        }

        .data-booking {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        .data-booking th,
        .data-booking td {
            border: 1px solid #ddd;
            padding: 8px 10px;
            text-align: left;
            font-size: 9.5pt;
        }

        .data-booking th {
            background-color: #2b6cb0;
            color: white;
            font-weight: bold;
            text-align: center;
        }

        .data-booking tr:nth-child(even) {
            background-color: #f7fafc;
        }

        .center {
            text-align: center;
        }

        .notice {
            margin-top: 20px;
            padding: 10px;
            border: 1px dashed #e2e8f0;
            background-color: #edf2f7;
            font-size: 9pt;
        }

        .footer {
            margin-top: 30px;
            float: right;
            text-align: center;
            width: 200px;
            font-size: 9.5pt;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>PERPUSTAKAAN E-LIBRARY UNM</h1>
        <p>BUKTI RESERVASI / PEMESANAN BUKU ONLINE</p>
    </div>

    <table class="info">
        <tr>
            <th>ID Booking</th>
            <td><strong>{{ $data_booking[0]->id_booking }}</strong></td>
            <th>Nama Anggota</th>
            <td>{{ $data_booking[0]->anggota->nama ?? '-' }}</td>
        </tr>
        <tr>
            <th>Tanggal Booking</th>
            <td>{{ date('d-m-Y H:i', strtotime($data_booking[0]->tgl_booking)) }} WIB</td>
            <th>Batas Ambil</th>
            <td><strong style="color: #c53030;">{{ date('d-m-Y H:i', strtotime($data_booking[0]->batas_ambil)) }} WIB</strong></td>
        </tr>
    </table>

    <table class="data-booking">
        <thead>
            <tr>
                <th class="center" style="width: 30px;">#</th>
                <th>Judul Buku</th>
                <th>Kategori</th>
                <th>Pengarang</th>
                <th>Penerbit</th>
                <th class="center" style="width: 60px;">Tahun</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($data_booking as $booking)
                @foreach ($booking->booking_detail as $detail)
                    <tr>
                        <td class="center">{{ $no++ }}</td>
                        <td><strong>{{ $detail->buku->judul_buku ?? '-' }}</strong></td>
                        <td>{{ $detail->buku->kategori->nama_kategori ?? '-' }}</td>
                        <td>{{ $detail->buku->pengarang ?? '-' }}</td>
                        <td>{{ $detail->buku->penerbit ?? '-' }}</td>
                        <td class="center">{{ $detail->buku->tahun_terbit ?? '-' }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    <div class="notice">
        <strong>Syarat & Ketentuan Pengambilan Buku:</strong>
        <ol style="margin: 5px 0 0 20px; padding: 0;">
            <li>Tunjukkan bukti booking ini (cetak atau digital) kepada petugas perpustakaan saat pengambilan buku.</li>
            <li>Batas waktu pengambilan buku adalah 1x24 jam sejak booking dibuat. Jika melebihi batas waktu, reservasi buku akan dibatalkan secara otomatis oleh sistem.</li>
            <li>Maksimal waktu peminjaman buku dan tarif denda keterlambatan ditentukan oleh petugas perpustakaan saat verifikasi fisik.</li>
        </ol>
    </div>

    <div class="footer">
        <p>Petugas Perpustakaan,</p>
        <br><br><br>
        <p>____________________</p>
    </div>
</body>
</html>
