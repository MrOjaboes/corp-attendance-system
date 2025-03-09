<?php

namespace Database\Seeders;

use DB;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $user = User::create([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'role' => 'admin',
            'password' => Hash::make('admin@admin.com'),
        ]);
        $role = Role::create([
            'slug' => 'admin',
            'name' => 'Adminstrator',
        ]);
        $user->roles()->sync($role->id);
        $this->call([
            UserSeeder::class,
        ]);
    }
}
