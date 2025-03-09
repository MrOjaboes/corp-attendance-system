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
        //Dashboard statistics
        $totalEmp =  count(Employee::all());
        $AllAttendance = count(Attendance::whereAttendance_date(date("Y-m-d"))->get());
        $ontimeEmp = count(Attendance::whereAttendance_date(date("Y-m-d"))->whereStatus('1')->get());
        $latetimeEmp = count(Attendance::whereAttendance_date(date("Y-m-d"))->whereStatus('0')->get());

        if ($AllAttendance > 0) {
            $percentageOntime = str_split(($ontimeEmp / $AllAttendance) * 100, 4)[0];
        } else {
            $percentageOntime = 0;
        }

        $data = [$totalEmp, $ontimeEmp, $latetimeEmp, $percentageOntime];

        return view('home.index')->with(['data' => $data]);
    }

    public function attendance()
    {
        $employee = Employee::find(auth()->user()->employee_id);
        $now = now()->setTimezone('Africa/Lagos');
        $startTime = $now->copy()->startOfDay(); // 12:00 AM
        $endTime = $now->copy()->startOfDay()->addHours(10); // 10:00 AM

        if ($now->greaterThanOrEqualTo($endTime)) {
            // If it's past 10 AM, attendance is closed
            return view('home.attendance', ['attendanceOpen' => true, 'countdownTime' => 0,'employee'=>$employee]);
        }

        // Calculate countdown time in milliseconds for JavaScript
        $countdownTime = $endTime->timestamp * 1000;
        return view('home.attendance', ['attendanceOpen' => true, 'countdownTime' => $countdownTime,'employee'=>$employee]);
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
