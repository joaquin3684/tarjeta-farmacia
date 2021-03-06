<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AfiliadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Db::transaction(function() {
            $this->call(ObraSocialSeeder::class);
            factory(\App\Afiliado::class, 2)->create();

        });
    }
}
