<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Employee;
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
        $employees = Employee::where('status', 0)->get();
        foreach ($employees as $employee) {
            Attendance::create([
                'emp_id' => $employee->id,
                'attendance_time' => date('H:i:s'),
                'attendance_date' => now(),
                'status' => 0,
            ]);
            $$employee->update([
                'status' => 1,
            ]);
        }
        Employee::where('status', 1)->update([
            'status' => 0,
        ]);
        $this->info('Attendance marked for users who missed submission.');
    }
}
