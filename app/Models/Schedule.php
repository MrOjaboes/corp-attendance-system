<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    public function getRouteKeyName()
    {
        return 'slug';
    }
    protected $fillable = [
        'user_id',
        'time_in',
        'time_out',
    ];
    public function employees()
    {
        return $this->belongsToMany('App\Models\Employee', 'schedule_employees', 'schedule_id', 'emp_id');
    }
}
