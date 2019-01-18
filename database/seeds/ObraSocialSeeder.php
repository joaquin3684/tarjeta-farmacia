<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ObraSocialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Db::transaction(function() {

            factory(\App\ObraSocial::class)->create();


        });
    }
}
