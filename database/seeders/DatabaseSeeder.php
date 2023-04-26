<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Role::create(['name' => 'superadmin']);
        // Role::create(['name' => 'guru']);
        // Role::create(['name' => 'kurator']);
        
        $user = User::factory()->create([
            'name' => 'Sukamto',
            'email' => 'sukamto@gmail.com',
            'password' => bcrypt('123456')
        ]);
        $user->assignRole('guru');
    }
}
