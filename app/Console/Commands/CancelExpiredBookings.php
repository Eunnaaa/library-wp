<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CancelExpiredBookings extends Command
{
    protected $signature = 'bookings:cancel-expired';

    protected $description = 'Cancel bookings past their batas_ambil deadline and restore stock';

    public function handle()
    {
        $expiredBookings = Booking::with('booking_detail')
            ->where('batas_ambil', '<', Carbon::now())
            ->get();

        if ($expiredBookings->isEmpty()) {
            $this->info('Tidak ada booking kedaluwarsa.');

            return Command::SUCCESS;
        }

        $count = 0;
        foreach ($expiredBookings as $booking) {
            DB::beginTransaction();
            try {
                foreach ($booking->booking_detail as $detail) {
                    DB::table('buku')
                        ->where('id', $detail->id_buku)
                        ->where('dibooking', '>', 0)
                        ->decrement('dibooking');

                    DB::table('buku')
                        ->where('id', $detail->id_buku)
                        ->increment('stok');
                }

                $booking->booking_detail()->delete();
                $booking->delete();

                DB::commit();
                $count++;
            } catch (\Exception $e) {
                DB::rollBack();
                $this->error("Gagal membatalkan booking {$booking->id_booking}: {$e->getMessage()}");
            }
        }

        $this->info("Berhasil membatalkan {$count} booking kedaluwarsa.");

        return Command::SUCCESS;
    }
}
