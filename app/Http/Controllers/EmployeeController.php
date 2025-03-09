<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Employee;
use App\Models\Schedule;
use App\Http\Requests\EmployeeRec;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class EmployeeController extends Controller
{

    public function index()
    {

        return view('admin.employee')->with(['employees' => Employee::all(), 'schedules' => Schedule::all()]);
    }

    public function store(EmployeeRec $request)
    {
        DB::beginTransaction();
        if ($request) {
            $employee = Employee::create([
                'name' => $request->name,
                'email' => $request->email,
                'pin_code' => rand(100000, 999999),
            ]);
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'employee_id' => $employee->id,
                'role' => 'user',
                'password' => Hash::make($request->email),
            ]);


            if ($employee && $user) {
                DB::commit();
                flash()->success('Success', 'Employee Record has been created successfully !');

                return redirect()->route('employees.index')->with('success');
            }
        }

        DB::rollBack();
        return back();
    }


    public function update(EmployeeRec $request, $id)
    {
        $request->validated();
        $employee = Employee::findOrFail($id);
        $employee->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        flash()->success('Success', 'Employee Record has been Updated successfully !');

        return redirect()->route('employees.index')->with('success');
    }


    public function destroy(Employee $employee)
    {
        User::where('employee_id', $employee->id)->delete();
        $employee->delete();
        flash()->success('Success', 'Employee Record has been Deleted successfully !');
        return redirect()->route('employees.index')->with('success');
    }
}
