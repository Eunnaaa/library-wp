<?php

namespace App\Exports;

use App\Models\PinjamDetail;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PinjamExport implements FromCollection, WithHeadings, WithMapping
{
    protected $startDate;

    protected $endDate;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate ? Carbon::parse($startDate)->startOfDay() : null;
        $this->endDate = $endDate ? Carbon::parse($endDate)->endOfDay() : null;
    }

    public function collection()
    {
        $query = PinjamDetail::with(['pinjam.anggota', 'pinjam.petugas_pinjam', 'buku'])
            ->where('status', 'Pinjam');

        if ($this->startDate && $this->endDate) {
            $query->whereHas('pinjam', function ($q) {
                $q->whereBetween('tgl_pinjam', [$this->startDate, $this->endDate]);
            });
        }

        return $query->orderBy('no_pinjam', 'DESC')->get();
    }

    public function map($detail): array
    {
        return [
            $detail->no_pinjam,
            $detail->pinjam && $detail->pinjam->tgl_pinjam ? Carbon::parse($detail->pinjam->tgl_pinjam)->format('d-m-Y') : '-',
            $detail->pinjam && $detail->pinjam->anggota ? $detail->pinjam->anggota->nama : 'Tidak Ada Anggota',
            $detail->buku ? $detail->buku->judul_buku : 'Tidak Ada Judul',
            $detail->status,
            $detail->pinjam && $detail->pinjam->petugas_pinjam ? $detail->pinjam->petugas_pinjam->nama : 'Tidak Ada Petugas',
        ];
    }

    public function headings(): array
    {
        return [
            'No Peminjaman',
            'Tanggal Pinjam',
            'Nama Peminjam',
            'Judul Buku',
            'Status',
            'Petugas Pinjam',
        ];
    }
}
