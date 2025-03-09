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
        $endTime = $now->copy()->startOfDay()->addHours(10); // 10:00 AM

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

        if (isset($request->attd)) {
            foreach ($request->attd as $keys => $values) {
                foreach ($values as $key => $value) {
                    if ($employee = Employee::whereId(request('emp_id'))->first()) {
                        if (
                            !Attendance::whereAttendance_date($keys)
                                ->whereEmp_id($key)
                                ->whereType(0)
                                ->first()
                        ) {
                            $data = new Attendance();

                            $data->emp_id = $key;
                            $emp_req = Employee::whereId($data->emp_id)->first();
                            $data->attendance_time = date('H:i:s', strtotime($emp_req->schedules->first()->time_in));
                            $data->attendance_date = $keys;

                            // $emps = date('H:i:s', strtotime($employee->schedules->first()->time_in));
                            // if (!($emps >= $data->attendance_time)) {
                            //     $data->status = 0;

                            // }
                            $data->save();
                        }
                    }
                }
            }
        }
        flash()->success('Success', 'You have successfully submited the attendance !');
        return back();
    }
}
