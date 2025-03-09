<?php

namespace Database\Seeders;

use DB;
use App\Models\Role;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $employee = Employee::create([
            'name' => 'employee',
            'email' => 'employee@admin.com',
            'pin_code' => rand(100000, 999999),
        ]);
        User::create([
            'name' => 'employee',
            'email' => 'employee@employee.com',
            'employee_id' => $employee->id,
            'role' => 'user',
            'password' => Hash::make('employee@employee.com'),
        ]);
    }
}
