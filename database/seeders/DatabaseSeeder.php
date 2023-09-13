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
        Role::create(['name' => 'tamu']);
        
        // $users = array('ibudiarsa91@admin.sd.belajar.id', 'yanti.oka233@gmail.com', 'i5347@guru.sd.belajar.id', 'anakpuspita46@guru.sd.belajar.id', 'putuspd60@admin.sd.belajar.id', 'idanurina51@guru.paud.belajar.id', 'imudiartana77@admin.sd.belajar.id', 'yurinathasya@gmail.com', 'sp.asr2468@instruktur.belajar.id', 'putudewi51@guru.smp.belajar.id', 'mc4diaz@gmail.com', 'iandika35@guru.smp.belajar.id', 'ipermana65@admin.paud.belajar.id', 'dianlestariyani@gmail.com', 'putulaksmi16@guru.sd.belajar.id', 'agusugrasena@gmail.com', 'retnowulandari231@guru.sd.belajar.id', 'indrapraekanata@gmail.com', 'ekaarseni@gmail.com', 'niwulandhari89@guru.sma.belajar.id', 'nispd126@admin.sd.belajar.id', 'niastutiama43@admin.sd.belajar.id', 'dayuindra95@gmail.com', 'niartini99@admin.sd.belajar.id', 'wayanrianti32@gmail.com', 'renidwi4990@gmail.com', 'nisag42@guru.sd.belajar.id', 'madesuryaningsih9@gmail.com', 'i4267@guru.sd.belajar.id', 'komangwirahayu17@admin.sd.belajar.id', 'yansi462@guru.sd.belajar.id', 'wayanaryani38@guru.smp.belajar.id', 'iwiguna11@guru.smp.belajar.id', 'niindradewi81@guru.smp.belajar.id', 'wardanikusuma15@gmail.com', 'ewixswandewi@gmail.com', 'isunarta64@guru.sd.belajar.id', 'sudiartagede314@gmail.com', 'ipranata51@admin.sd.belajar.id', 'isuryawan89@guru.sd.belajar.id', 'gederaga051187@gmail.com', 'idaayu.laxmi26@gmail.com', 'adekamet1@gmail.com', 'dewajayananda63@admin.sd.belajar.id', 'ninuriyanthi04@guru.smp.belajar.id', 'iardika74@admin.sd.belajar.id', 'niasriasih54@guru.sd.belajar.id', 'santisumardi91@guru.sma.belajar.id', 'dewasuandayani22@guru.smp.belajar.id', 'dayuemi86@gmail.com', 'misrini51@guru.sd.belajar.id', 'putuwidasari62@guru.smp.belajar.id', 'wayansuardani8@gmail.com', 'imade.sedanayasa78@gmail.com', 'okaa89@guru.smp.belajar.id', 'ikertiyasa72@guru.sd.belajar.id', 'saniscananda@gmail.com', 'ayuharmonii@gmail.com', 'ngurahsuwantarabali@gmail.com', 'isurata29@guru.sd.belajar.id', 'inisuci76@gmail.com', 'isuhendra01@guru.sd.belajar.id', );

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
         
    }
}
