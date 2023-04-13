<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i <= 20; $i++) { 
            $sample = 'users'.$i;
            DB::table('users')->insert([
                'username' => $sample,
                'password' => bcrypt('password'),
                'fullname' => $sample,
                'created_at' => Carbon::parse(now())->format("Y-m-d H:i:s"),
                'updated_at' => Carbon::parse(now())->format("Y-m-d H:i:s")
            ]);
        }
    }
}
