<?php

namespace App\Exports;

use App\Models\Pinjam;
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
        $query = Pinjam::with(['pinjam_detail.buku', 'pinjam_detail.petugas_kembali', 'petugas_pinjam', 'anggota'])
            ->whereHas('pinjam_detail', function ($q) {
                $q->where('status', 'Pinjam');
            });

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('tgl_pinjam', [$this->startDate, $this->endDate]);
        }

        return $query->orderBy('no_pinjam', 'DESC')->get();
    }

    public function map($row): array
    {
        $mappedRows = [];
        foreach ($row->pinjam_detail as $detail) {
            $mappedRows[] = [
                $row->no_pinjam,
                Carbon::parse($row->tgl_pinjam)->format('d-m-Y'),
                $row->anggota->nama ?? 'Tidak Ada Anggota',
                $detail->buku->judul_buku ?? 'Tidak Ada Judul',
                $detail->status,
                $row->petugas_pinjam->nama ?? 'Tidak Ada Petugas',
            ];
        }
        return $mappedRows;
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
