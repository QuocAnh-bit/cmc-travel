<?php



namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;

class CheckBookingExpired extends Command
{
    protected $signature = 'app:check-booking-expired';
    protected $description = 'Check and expire bookings';

    public function handle()
    {
        $count = Booking::where('status', 'pending')
            ->where('expires_at', '<', now())
            ->update([
                'status' => 'expired'
            ]);



        return 0;
    }
}
