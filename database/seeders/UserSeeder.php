<?php

namespace Database\Seeders;

use DB;
use App\Models\Role;
use App\Models\User;
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
        $user= User::create([
            'name' => 'employee',
            'email' => 'employee@admin.com',
            'password' => Hash::make('employee@admin.com'),
        ]);
        $role = Role::create([
            'slug' => 'user',
            'name' => 'User',
        ]);
        $user->roles()->sync($role->id);
    }
}
