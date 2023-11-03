<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Biodata;
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
        // Role::create(['name' => 'kepalasekolah']);
        // Role::create(['name' => 'operator']);
        Role::create(['name' => 'tendik']);
        
        // $users = array('ketutartayasa22@admin.sd.belajar.id', 'luhwidyastutispd83@guru.sd.belajar.id', 'mariaulfa55@guru.sd.belajar.id', 'niastuti40@guru.sd.belajar.id', 'nimaheni56@admin.smp.belajar.id', 'nisugilastini33@guru.smp.belajar.id', 'purwasila.ipa@gmail.com', 'remaitamanalu30@guru.sd.belajar.id', 'shandyastini311090@gmail.com', 'wikahiskayana@gmail.com', 'yoniriskayanti238@gmail.com');

        // foreach ($users as $item) {
        //     $name = explode('@', $item);
        //     $user = User::factory()->create([
        //         'name' => $name[0],
        //         'email' => $item,
        //         'password' => bcrypt('123456')
        //     ]);
        //     $user->assignRole('guru');
        //     $biodata = Biodata::create([
        //         'id' => $user->id
        //     ]);
        // }
        // $user = User::factory()->create([
        //             'name' => 'febry_san',
        //             'email' => 'febrysan1995@gmail.com',
        //             'password' => bcrypt('123456')
        //         ]);
        //         $user->assignRole('superadmin');
        //         $biodata = Biodata::create([
        //             'id' => $user->id
        //         ]);              
    }
}
