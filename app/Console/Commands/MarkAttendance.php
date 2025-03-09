<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Attendance;
use Illuminate\Console\Command;

class MarkAttendance extends Command
{
    protected $signature = 'attendance:mark';
    protected $description = 'Automatically mark attendance at 10 AM every day';

    public function handle()
    {
        $now = Carbon::now()->toDateString(); // Today's date

        // Mark attendance for users who have not submitted
        Attendance::whereDate('created_at', $now)
            ->whereNull('status') // Assuming 'status' column exists
            ->update(['status' => 'absent']);

        $this->info('Attendance marked for users who missed submission.');
    }
}
