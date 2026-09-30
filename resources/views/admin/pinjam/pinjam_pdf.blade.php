<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Laporan Transaksi Peminjaman - E-Library UNM</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 9.5pt;
            color: #1e293b;
            margin: 0;
            padding: 15px 25px;
            line-height: 1.4;
        }

        .header-kop {
            text-align: center;
            border-bottom: 3px double #1e293b;
            padding-bottom: 12px;
            margin-bottom: 15px;
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

        .report-meta {
            margin-bottom: 15px;
            font-size: 8.5pt;
            color: #475569;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 8px 12px;
        }

        .report-meta table {
            width: 100%;
            border-collapse: collapse;
        }

        .report-meta td {
            padding: 2px 4px;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.data-table th {
            background-color: #1e3a8a;
            color: #ffffff;
            font-weight: bold;
            font-size: 8.5pt;
            padding: 7px 8px;
            text-align: left;
            border: 1px solid #1e3a8a;
        }

        table.data-table td {
            padding: 6px 8px;
            font-size: 8pt;
            border: 1px solid #e2e8f0;
        }

        table.data-table tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .text-center {
            text-align: center;
        }

        .footer {
            margin-top: 30px;
            float: right;
            text-align: center;
            width: 220px;
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

    <div class="report-meta">
        <table>
            <tr>
                <td style="width: 50%;">
                    <strong>Dokumen:</strong> Rekapitulasi Sirkulasi Peminjaman Buku
                </td>
                <td style="width: 50%; text-align: right;">
                    <strong>Dicetak Pada:</strong> {{ date('d F Y, H:i') }} WIB
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Dicetak Oleh:</strong> {{ Auth::user()->nama ?? 'Administrator' }} ({{ Auth::user()->email ?? '-' }})
                </td>
                <td style="text-align: right;">
                    <strong>Status Dokumen:</strong> Arsip Resmi Sirkulasi
                </td>
            </tr>
        </table>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th class="text-center" style="width: 25px;">#</th>
                <th style="width: 95px;">No. Pinjam</th>
                <th class="text-center" style="width: 70px;">Tgl Pinjam</th>
                <th class="text-center" style="width: 70px;">Batas Kembali</th>
                <th>Judul Buku & Kategori</th>
                <th class="text-center" style="width: 60px;">Status</th>
                <th style="width: 120px;">Anggota</th>
                <th style="width: 100px;">Petugas</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @forelse ($data_pinjam as $pinjam)
                @foreach ($pinjam->pinjam_detail as $detail)
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td><strong>{{ $pinjam->no_pinjam }}</strong></td>
                        <td class="text-center">{{ date('d/m/Y', strtotime($pinjam->tgl_pinjam)) }}</td>
                        <td class="text-center">{{ date('d/m/Y', strtotime($detail->tgl_kembali)) }}</td>
                        <td>
                            <strong>{{ $detail->buku->judul_buku ?? 'Buku Dihapus' }}</strong>
                            <div style="color: #64748b; font-size: 7.5pt;">ISBN: {{ $detail->buku->isbn ?? '-' }}</div>
                        </td>
                        <td class="text-center">
                            <strong>{{ $detail->status }}</strong>
                        </td>
                        <td>{{ $pinjam->anggota->nama ?? '-' }}</td>
                        <td>{{ $pinjam->petugas_pinjam->nama ?? '-' }}</td>
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="8" class="text-center" style="padding: 20px; color: #64748b;">
                        Tidak ada riwayat transaksi peminjaman pada periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p style="margin: 0; color: #64748b;">Kepala / Petugas Sirkulasi,</p>
        <div style="height: 55px;"></div>
        <p style="margin: 0; font-weight: bold; border-top: 1px dotted #cbd5e1; display: inline-block; padding-top: 4px; min-width: 170px;">
            ( {{ Auth::user()->nama ?? 'Administrator' }} )
        </p>
    </div>
</body>
</html>
