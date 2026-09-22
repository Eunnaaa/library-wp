<?php

namespace App\Http\Controllers;

use App\Exports\PinjamExport;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Buku;
use App\Models\Pinjam;
use App\Models\PinjamDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class PinjamController extends Controller
{
    public function index()
    {
        return view('admin.pinjam.index');
    }

    public function getData(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        if (empty($startDate) || empty($endDate)) {
            $data_pinjam = Pinjam::with(['pinjam_detail' => function ($query) {
                $query->where('status', 'Pinjam');
            }, 'pinjam_detail.buku', 'pinjam_detail.petugas_kembali', 'petugas_pinjam', 'anggota'])
                ->whereHas('pinjam_detail', function ($query) {
                    $query->where('status', 'Pinjam');
                })
                ->orderBy('no_pinjam', 'DESC')
                ->get();
        } else {
            $endDate = Carbon::parse($endDate)->endOfDay()->toDateTimeString();
            $startDate = Carbon::parse($startDate)->startOfDay()->toDateTimeString();

            $data_pinjam = Pinjam::with(['pinjam_detail' => function ($query) {
                $query->where('status', 'Pinjam');
            }, 'pinjam_detail.buku', 'pinjam_detail.petugas_kembali', 'petugas_pinjam', 'anggota'])
                ->whereHas('pinjam_detail', function ($query) {
                    $query->where('status', 'Pinjam');
                })
                ->whereBetween('tgl_pinjam', [$startDate, $endDate])
                ->orderBy('no_pinjam', 'DESC')
                ->get();
        }

        $flattenedData = $data_pinjam->flatMap(function ($pinjam) {
            return $pinjam->pinjam_detail->map(function ($detail) use ($pinjam) {
                $coverUrl = asset('storage/' . ($detail->buku->image ?? 'cover-buku/book-default-cover.jpg'));
                $url = route('admin.transaksi.pinjam.kembalikanBuku', ['no_pinjam' => $pinjam->no_pinjam, 'id_buku' => $detail->id_buku]);
                return [
                    'id_buku' => $detail->id_buku,
                    'no_pinjam' => $pinjam->no_pinjam,
                    'tgl_pinjam' => Carbon::parse($pinjam->tgl_pinjam)->format('d-m-Y'),
                    'tgl_kembali' => Carbon::parse($detail->tgl_kembali)->format('d-m-Y'),
                    'lama_pinjam' => $detail->lama_pinjam . ' hari',
                    'judul_buku' => $detail->buku->judul_buku ?? 'Buku Tidak Ditemukan',
                    'status' => '<span class="badge badge-info">' . $detail->status . '</span>',
                    'gambar' => '<img src="' . $coverUrl . '" class="img-thumbnail" width="50" alt="Cover">',
                    'anggota' => $pinjam->anggota->nama ?? '-',
                    'petugas' => $pinjam->petugas_pinjam->nama ?? '-',
                    'aksi' => '
                        <form action="' . $url . '" method="POST" class="d-inline form-kembalikan">
                            ' . csrf_field() . '
                            <input type="hidden" name="_method" value="PUT">
                            <button type="submit" class="btn btn-sm btn-primary kembalikan-buku" data-toggle="tooltip" title="Kembalikan Buku">
                                <i class="fas fa-angle-double-left"></i> Kembalikan
                            </button>
                        </form>',
                ];
            });
        });

        return DataTables::of($flattenedData)
            ->addIndexColumn()
            ->rawColumns(['status', 'gambar', 'aksi'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_booking' => 'required',
            'lama' => 'required|array',
            'denda' => 'required|array',
        ]);

        DB::transaction(function () use ($request) {
            $id_booking = $request->input('id_booking');
            $booking = Booking::where('id_booking', $id_booking)->firstOrFail();
            $id_user = $booking->id_user;

            $todayDate = Carbon::now()->format('ymd');
            $countToday = Pinjam::whereDate('created_at', Carbon::today())->count();
            $nextPinjamNumber = str_pad($countToday + 1, 3, '0', STR_PAD_LEFT);
            $no_pinjam = 'P' . $todayDate . $nextPinjamNumber;

            $tgl_pinjam = Carbon::now();
            $status = 'Pinjam';

            $pinjam = Pinjam::create([
                'no_pinjam' => $no_pinjam,
                'tgl_pinjam' => $tgl_pinjam,
                'id_booking' => $id_booking,
                'id_user' => $id_user,
                'total_denda' => 0,
                'id_petugas_pinjam' => Auth::id(),
            ]);

            $bookingDetails = BookingDetail::where('id_booking', $id_booking)->get();

            foreach ($request->input('denda') as $index => $denda) {
                if (!isset($bookingDetails[$index])) {
                    continue;
                }
                $id_buku = $bookingDetails[$index]->id_buku;
                $lama_pinjam = $request->input('lama')[$index];
                $tgl_kembali = Carbon::parse($tgl_pinjam)->addDays((int)$lama_pinjam);

                PinjamDetail::create([
                    'no_pinjam' => $no_pinjam,
                    'id_buku' => $id_buku,
                    'tgl_kembali' => $tgl_kembali,
                    'tgl_pengembalian' => null,
                    'denda' => $denda,
                    'lama_pinjam' => $lama_pinjam,
                    'status' => $status,
                ]);

                // Update stok buku
                $buku = Buku::find($id_buku);
                if ($buku) {
                    $buku->dibooking = max(0, $buku->dibooking - 1);
                    $buku->dipinjam = $buku->dipinjam + 1;
                    $buku->save();
                }
            }

            // Hapus data dari tabel booking dan booking_detail
            BookingDetail::where('id_booking', $id_booking)->delete();
            Booking::where('id_booking', $id_booking)->delete();
        });

        return redirect()->route('admin.transaksi.peminjaman.index')->with('success', 'Data pinjaman berhasil disimpan dan booking telah diproses.');
    }

    public function kembalikanBuku($no_pinjam, $id_buku)
    {
        $pinjamDetail = PinjamDetail::where('no_pinjam', $no_pinjam)
            ->where('id_buku', $id_buku)
            ->where('status', 'Pinjam')
            ->first();

        if ($pinjamDetail) {
            $now = Carbon::now();
            $tgl_kembali = Carbon::parse($pinjamDetail->tgl_kembali);

            // Hitung denda keterlambatan jika ada
            $terlambat = max(0, $now->diffInDays($tgl_kembali, false) * -1);
            $totalDenda = $terlambat * $pinjamDetail->denda;

            $pinjamDetail->tgl_pengembalian = $now;
            $pinjamDetail->status = 'Kembali';
            $pinjamDetail->id_petugas_kembali = Auth::id();
            $pinjamDetail->save();

            // Update status buku
            $buku = Buku::find($id_buku);
            if ($buku) {
                $buku->dipinjam = max(0, $buku->dipinjam - 1);
                $buku->stok += 1;
                $buku->save();
            }

            // Update total denda di tabel pinjam
            $pinjam = Pinjam::where('no_pinjam', $no_pinjam)->first();
            if ($pinjam && $totalDenda > 0) {
                $pinjam->total_denda += $totalDenda;
                $pinjam->save();
            }

            return response()->json([
                'success' => 'Buku berhasil dikembalikan.' . ($totalDenda > 0 ? " Denda keterlambatan: Rp " . number_format($totalDenda, 0, ',', '.') : '')
            ]);
        }

        return response()->json(['error' => 'Detail pinjaman tidak ditemukan atau sudah dikembalikan.'], 404);
    }

    public function pengembalian_index()
    {
        $data_pinjam = Pinjam::with(['pinjam_detail' => function ($query) {
            $query->where('status', 'Kembali');
        }, 'pinjam_detail.buku', 'pinjam_detail.petugas_kembali', 'petugas_pinjam', 'anggota'])
            ->whereHas('pinjam_detail', function ($query) {
                $query->where('status', 'Kembali');
            })
            ->orderBy('no_pinjam', 'DESC')
            ->get();

        return view('admin.pinjam.pengembalian_index', compact('data_pinjam'));
    }

    public function exportPdfPinjam(Request $request)
    {
        $startDate = $request->start_date ? Carbon::parse($request->start_date)->startOfDay() : null;
        $endDate = $request->end_date ? Carbon::parse($request->end_date)->endOfDay() : null;

        $query = Pinjam::with(['pinjam_detail.buku', 'pinjam_detail.petugas_kembali', 'petugas_pinjam', 'anggota'])
            ->whereHas('pinjam_detail', function ($q) {
                $q->where('status', 'Pinjam');
            });

        if ($startDate && $endDate) {
            $query->whereBetween('tgl_pinjam', [$startDate, $endDate]);
        }

        $data_pinjam = $query->orderBy('no_pinjam', 'DESC')->get();

        $pdf = Pdf::loadView('admin.pinjam.pinjam_pdf', compact('data_pinjam'));
        return $pdf->download('transaksi_pinjam.pdf');
    }

    public function exportExcelPinjam(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        return Excel::download(new PinjamExport($startDate, $endDate), 'data-pinjam.xlsx');
    }
}
