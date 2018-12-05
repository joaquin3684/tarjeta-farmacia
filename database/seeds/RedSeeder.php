<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Db::transaction(function() {

            factory(\App\Red::class)->create(['credito' => 5000]);
            factory(\App\Red::class)->create(['credito' => 3000]);


        });
    }
}
