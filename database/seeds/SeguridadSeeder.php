<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SeguridadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Db::transaction(function(){


            $perfil1 = factory(App\Perfil::class)->create(['nombre' => 'afiliado']);
            $perfil2 = factory(App\Perfil::class)->create(['nombre' => 'farmacia']);
            $perfil = factory(App\Perfil::class)->create(['nombre' => 'admin']);

        $pantalla = factory(App\Pantalla::class)->create(['nombre' => 'afiliado']);
        $pantalla1 = factory(App\Pantalla::class)->create(['nombre' => 'solicitud']);
        $pantalla2 = factory(App\Pantalla::class)->create(['nombre' => 'venta']);
        $pantalla3 = factory(App\Pantalla::class)->create(['nombre' => 'producto']);
        $pantalla4 = factory(App\Pantalla::class)->create(['nombre' => 'red']);
        $pantalla5 = factory(App\Pantalla::class)->create(['nombre' => 'farmacia']);



        $user = factory(App\User::class)->create(['id_perfil' => \App\Perfiles::ADMIN, 'name' => 'prueba', 'password' => Hash::make('prueba')]);
        $userFarmacia = factory(App\User::class)->create(['id_perfil' => \App\Perfiles::FARMACIA, 'name' => 'farmacia', 'password' => Hash::make('farmacia')]);
        $userAfiliado = factory(App\User::class)->create(['id_perfil' => \App\Perfiles::AFILIADO, 'name' => 'afiliado', 'password' => Hash::make('afiliado')]);

       // $user->perfil()->attach($perfil->id);

            $perfil2->pantallas()->attach($pantalla->id);
            $perfil2->pantallas()->attach($pantalla1->id);
            $perfil2->pantallas()->attach($pantalla3->id);

            $perfil1->pantallas()->attach($pantalla->id);
            $perfil1->pantallas()->attach($pantalla5->id);

        $perfil->pantallas()->attach($pantalla->id);
        $perfil->pantallas()->attach($pantalla1->id);
        $perfil->pantallas()->attach($pantalla2->id);
        $perfil->pantallas()->attach($pantalla3->id);
        $perfil->pantallas()->attach($pantalla4->id);
        $perfil->pantallas()->attach($pantalla5->id);


        });

    }
}
