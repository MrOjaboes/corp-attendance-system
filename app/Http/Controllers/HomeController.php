<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Employee;
use App\Models\Schedule;
use App\Models\Attendance;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $employee = Employee::find(auth()->user()->employee_id);
        $now = now()->setTimezone('Africa/Lagos');
        $startTime = $now->copy()->startOfDay(); // 12:00 AM
        $endTime = $now->copy()->startOfDay()->addHours(15); // 10:00 AM

        if ($now->greaterThanOrEqualTo($endTime)) {
            // If it's past 10 AM, attendance is closed
            return view('home.index', ['attendanceOpen' => false, 'countdownTime' => 0, 'employee' => $employee]);
        }

        // Calculate countdown time in milliseconds for JavaScript
        $countdownTime = $endTime->timestamp * 1000;

        return view('home.index', ['attendanceOpen' => true, 'countdownTime' => $countdownTime, 'employee' => $employee]);
    }

    public function attendance()
    {
        $attendances = Attendance::where('emp_id', auth()->user()->employee_id)->get();
        return view('home.attendance', compact('attendances'));
    }

    public function CheckStore(Request $request)
    {

        $employee = Employee::find(auth()->user()->employee_id);
        $current_date = date('Y-m-d');
        $dataexist = Attendance::whereDate('created_at', $current_date)
            ->where('emp_id', auth()->user()->employee_id)
            ->get();

        //dd($dataexist);
        if (count($dataexist) !== 0) {
            return redirect()
                ->back()
                ->with('error', 'Attendance Already Taken!');
        }

        if (isset($request->attd)) {
            Attendance::create([
                'emp_id' => auth()->user()->employee_id,
                'attendance_time' => date('H:i:s'),
                'attendance_date' => now(),
                'status' => 1,
            ]);
            $employee->update([
                'status' => 1
            ]);
        }
        flash()->success('Success', 'You have successfully submited the attendance !');
        return back();
    }
}
