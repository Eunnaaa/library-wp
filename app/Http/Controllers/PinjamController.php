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
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

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
                $coverUrl = asset('storage/'.($detail->buku->image ?? 'cover-buku/book-default-cover.jpg'));
                $url = route('admin.transaksi.pinjam.kembalikanBuku', ['no_pinjam' => $pinjam->no_pinjam, 'id_buku' => $detail->id_buku]);

                return [
                    'id_buku' => $detail->id_buku,
                    'no_pinjam' => $pinjam->no_pinjam,
                    'tgl_pinjam' => Carbon::parse($pinjam->tgl_pinjam)->format('d-m-Y'),
                    'tgl_kembali' => Carbon::parse($detail->tgl_kembali)->format('d-m-Y'),
                    'lama_pinjam' => $detail->lama_pinjam.' hari',
                    'judul_buku' => $detail->buku->judul_buku ?? 'Buku Tidak Ditemukan',
                    'status' => '<span class="badge badge-info px-2 py-1 font-weight-bold" style="font-size: 0.78rem; border-radius: 6px;">'.$detail->status.'</span>',
                    'gambar' => '<div class="book-cover-thumb book-cover-thumb-sm"><img src="'.$coverUrl.'" alt="Cover" onerror="this.onerror=null;this.src=\''.asset('storage/cover-buku/book-default-cover.jpg').'\';"></div>',
                    'anggota' => $pinjam->anggota->nama ?? '-',
                    'petugas' => $pinjam->petugas_pinjam->nama ?? '-',
                    'aksi' => '
                        <form action="'.$url.'" method="POST" class="d-inline form-kembalikan">
                            '.csrf_field().'
                            <input type="hidden" name="_method" value="PUT">
                            <button type="submit" class="btn btn-sm btn-primary shadow-sm font-weight-bold px-3 py-1" style="border-radius: 6px;" data-toggle="tooltip" title="Kembalikan Buku">
                                <i class="fas fa-undo-alt mr-1"></i> Kembalikan
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
            $booking = Booking::where('id_booking', $id_booking)->lockForUpdate()->firstOrFail();
            $id_user = $booking->id_user;

            $todayDate = Carbon::now()->format('ymd');
            $prefix = 'P'.$todayDate;
            $existing = Pinjam::where('no_pinjam', 'like', $prefix.'%')
                ->lockForUpdate()
                ->pluck('no_pinjam');
            $maxSeq = 0;
            foreach ($existing as $np) {
                $seq = intval(substr($np, strlen($prefix)));
                if ($seq > $maxSeq) {
                    $maxSeq = $seq;
                }
            }
            $no_pinjam = $prefix.str_pad($maxSeq + 1, 3, '0', STR_PAD_LEFT);

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

            foreach ($bookingDetails as $detail) {
                $id_buku = $detail->id_buku;
                $lama_pinjam = $request->input("lama.{$id_buku}") ?? $request->input('lama.0') ?? 7;
                $denda = $request->input("denda.{$id_buku}") ?? $request->input('denda.0') ?? 1000;
                $tgl_kembali = Carbon::parse($tgl_pinjam)->addDays((int) $lama_pinjam);

                PinjamDetail::create([
                    'no_pinjam' => $no_pinjam,
                    'id_buku' => $id_buku,
                    'tgl_kembali' => $tgl_kembali,
                    'tgl_pengembalian' => null,
                    'denda' => $denda,
                    'lama_pinjam' => $lama_pinjam,
                    'status' => $status,
                ]);

                DB::table('buku')->where('id', $id_buku)->where('dibooking', '>', 0)->decrement('dibooking');
                DB::table('buku')->where('id', $id_buku)->increment('dipinjam');
            }

            BookingDetail::where('id_booking', $id_booking)->delete();
            Booking::where('id_booking', $id_booking)->delete();
        });

        return redirect()->route('admin.transaksi.peminjaman.index')->with('success', 'Data pinjaman berhasil disimpan dan booking telah diproses.');
    }

    public function kembalikanBuku($no_pinjam, $id_buku)
    {
        return DB::transaction(function () use ($no_pinjam, $id_buku) {
            $pinjamDetail = PinjamDetail::where('no_pinjam', $no_pinjam)
                ->where('id_buku', $id_buku)
                ->where('status', 'Pinjam')
                ->lockForUpdate()
                ->first();

            if ($pinjamDetail) {
                $now = Carbon::now();
                $today = Carbon::today();
                $tgl_kembali = Carbon::parse($pinjamDetail->tgl_kembali)->startOfDay();

                // Hitung denda keterlambatan jika tanggal pengembalian melewati tanggal jatuh tempo
                $terlambat = $today->greaterThan($tgl_kembali) ? (int) $tgl_kembali->diffInDays($today) : 0;
                $totalDenda = $terlambat * $pinjamDetail->denda;

                $pinjamDetail->tgl_pengembalian = $now;
                $pinjamDetail->status = 'Kembali';
                $pinjamDetail->id_petugas_kembali = Auth::id();
                $pinjamDetail->total_denda = $totalDenda;
                $pinjamDetail->save();

                // Update stok buku: decrement dipinjam, increment stok
                DB::table('buku')->where('id', $id_buku)->where('dipinjam', '>', 0)->decrement('dipinjam');
                DB::table('buku')->where('id', $id_buku)->increment('stok');

                // Update total denda di tabel pinjam
                if ($totalDenda > 0) {
                    DB::table('pinjam')->where('no_pinjam', $no_pinjam)->increment('total_denda', $totalDenda);
                }

                return response()->json([
                    'success' => 'Buku berhasil dikembalikan.'.($totalDenda > 0 ? ' Denda keterlambatan: Rp '.number_format($totalDenda, 0, ',', '.') : ''),
                ]);
            }

            return response()->json(['error' => 'Detail pinjaman tidak ditemukan atau sudah dikembalikan.'], 404);
        });
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
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $startDate = $request->filled('start_date') ? Carbon::parse($request->start_date)->startOfDay() : null;
        $endDate = $request->filled('end_date') ? Carbon::parse($request->end_date)->endOfDay() : null;

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
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $startDate = $request->start_date;
        $endDate = $request->end_date;

        return Excel::download(new PinjamExport($startDate, $endDate), 'data-pinjam.xlsx');
    }
}
