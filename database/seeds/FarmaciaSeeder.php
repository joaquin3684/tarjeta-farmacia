<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FarmaciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Db::transaction(function() {
            $this->call(RedSeeder::class);
            factory(\App\Farmacia::class, 2)->create()->each(function($farm){
                $farm->redes()->attach([1,2]);
            });


        });
    }
}
