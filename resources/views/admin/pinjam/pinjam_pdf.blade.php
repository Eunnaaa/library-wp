<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi Peminjaman</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11pt;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 0;
            font-size: 16pt;
        }
        .header p {
            margin: 4px 0 0 0;
            font-size: 10pt;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table, th, td {
            border: 1px solid #777;
        }
        th {
            background-color: #f2f2f2;
            padding: 8px;
            font-size: 10pt;
            text-align: center;
        }
        td {
            padding: 6px 8px;
            font-size: 9.5pt;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 9pt;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>PERPUSTAKAAN E-LIBRARY UNM</h2>
        <p>Laporan Data Transaksi Peminjaman Buku</p>
        <p><small>Dicetak pada: {{ date('d-m-Y H:i:s') }}</small></p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 25px;">#</th>
                <th style="width: 80px;">No. Pinjam</th>
                <th style="width: 75px;">Tgl Pinjam</th>
                <th style="width: 75px;">Tgl Kembali</th>
                <th>Judul Buku</th>
                <th style="width: 60px;">Status</th>
                <th>Anggota Peminjam</th>
                <th>Petugas</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse ($data_pinjam as $pinjam)
                @foreach ($pinjam->pinjam_detail as $detail)
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td class="text-center"><strong>{{ $pinjam->no_pinjam }}</strong></td>
                        <td class="text-center">{{ date('d-m-Y', strtotime($pinjam->tgl_pinjam)) }}</td>
                        <td class="text-center">{{ date('d-m-Y', strtotime($detail->tgl_kembali)) }}</td>
                        <td>{{ $detail->buku->judul_buku ?? '-' }}</td>
                        <td class="text-center">{{ $detail->status }}</td>
                        <td>{{ $pinjam->anggota->nama ?? '-' }}</td>
                        <td>{{ $pinjam->petugas_pinjam->nama ?? '-' }}</td>
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data peminjaman yang ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Petugas Perpustakaan,</p>
        <br><br><br>
        <p><strong>( {{ Auth::user()->nama ?? 'Administrator' }} )</strong></p>
    </div>
</body>
</html>
