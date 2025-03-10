<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Schedule;
use App\Http\Requests\ScheduleEmp;

class ScheduleController extends Controller
{

    public function index()
    {

        $schedule = schedule::first();
        return view('admin.schedule', compact('schedule'));
        flash()->success('Success', 'Schedule has been created successfully !');
    }


    public function store(ScheduleEmp $request)
    {
        $request->validated();
        schedule::updateOrCreate([
            'user_id' => auth()->user()->id,
        ], [
            'time_in' => Carbon::parse($request->time_in),
            'time_out' => Carbon::parse($request->time_out),
        ]);

        flash()->success('Success', 'Schedule has been created successfully !');
        return redirect()->route('schedule.index');
    }

    public function update(ScheduleEmp $request, Schedule $schedule)
    {
        $request['time_in'] = str_split($request->time_in, 5)[0];
        $request['time_out'] = str_split($request->time_out, 5)[0];

        $request->validated();

        $schedule->slug = 'ddd';
        $schedule->time_in = $request->time_in;
        $schedule->time_out = $request->time_out;
        $schedule->save();
        flash()->success('Success', 'Schedule has been Updated successfully !');
        return redirect()->route('schedule.index');
    }


    public function destroy(Schedule $schedule)
    {
        $schedule->delete();
        flash()->success('Success', 'Schedule has been deleted successfully !');
        return redirect()->route('schedule.index');
    }
}
