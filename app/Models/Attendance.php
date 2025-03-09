<?php

namespace App\Models;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model

{

    protected $table = 'attendances';

    protected $fillable = [
        'emp_id', 'attendance_time', 'attendance_date','status',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class,'emp_id');
    }
}
