<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CobroSeederTest extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function(){

            $this->call(FarmaciaSeeder::class);
            $this->call(AfiliadoSeeder::class);
            $this->call(ProductoSeeder::class);

            factory(\App\CuotaSocial::class)->create(['id_afiliado' => 1, 'total' => 100, 'pagado' => 0, 'fecha_pago' => null]);

            $ventaAf1 = factory(\App\Venta::class)->create(['id_afiliado' => 1, 'id_farmacia' => 1, 'nro_cuotas' => 3]);
            $ventaAf1->productos()->attach([1,2]);
            $cuota1 = factory(\App\Cuota::class)->create(['id_venta' => $ventaAf1->id,'pagado' => 0, 'capital' => 100, 'interes' => 50, 'fecha_vto' => \Carbon\Carbon::today()->addDays(30)->toDateString(),'fecha_calculo' => \Carbon\Carbon::today()->addDays(30)->toDateString(), 'fecha_inicio' => \Carbon\Carbon::today()->toDateString(), 'nro_cuota' => 1, 'total' => 150, 'actualizacion_punitorios' => null]);
            $cuota2 = factory(\App\Cuota::class)->create(['id_venta' => $ventaAf1->id,'pagado' => 0, 'capital' => 100, 'interes' => 50, 'fecha_vto' => \Carbon\Carbon::today()->addDays(60)->toDateString(),'fecha_calculo' => \Carbon\Carbon::today()->addDays(60)->toDateString(), 'fecha_inicio' => \Carbon\Carbon::today()->addDays(30)->toDateString(), 'nro_cuota' => 2, 'total' => 150, 'actualizacion_punitorios' => null]);
            $cuota3 = factory(\App\Cuota::class)->create(['id_venta' => $ventaAf1->id, 'pagado' => 0, 'capital' => 100, 'interes' => 50, 'fecha_vto' => \Carbon\Carbon::today()->addDays(90)->toDateString(),'fecha_calculo' => \Carbon\Carbon::today()->addDays(90)->toDateString(), 'fecha_inicio' => \Carbon\Carbon::today()->addDays(60)->toDateString(), 'nro_cuota' => 3, 'total' => 150, 'actualizacion_punitorios' => null]);

            factory(\App\CuotaSocial::class)->create(['id_afiliado' => 2, 'total' => 100, 'pagado' => 0, 'fecha_pago' => null, 'nro_cuota' => 1]);
            factory(\App\CuotaSocial::class)->create(['id_afiliado' => 2, 'total' => 100, 'pagado' => 0, 'fecha_pago' => null, 'nro_cuota' => 2]);

            $ventaAf2 = factory(\App\Venta::class)->create(['id_afiliado' => 2, 'id_farmacia' => 1, 'nro_cuotas' => 3]);
            $ventaAf2->productos()->attach([1,2]);

            $cuota1 = factory(\App\Cuota::class)->create(['id_venta' => $ventaAf2->id,'pagado' => 0, 'capital' => 100, 'interes' => 50, 'fecha_vto' => \Carbon\Carbon::today()->addDays(30)->toDateString(),'fecha_calculo' => \Carbon\Carbon::today()->addDays(30)->toDateString(), 'fecha_inicio' => \Carbon\Carbon::today()->toDateString(), 'nro_cuota' => 1, 'total' => 150, 'actualizacion_punitorios' => null]);
            $cuota2 = factory(\App\Cuota::class)->create(['id_venta' => $ventaAf2->id,'pagado' => 0, 'capital' => 100, 'interes' => 50, 'fecha_vto' => \Carbon\Carbon::today()->addDays(60)->toDateString(),'fecha_calculo' => \Carbon\Carbon::today()->addDays(60)->toDateString(), 'fecha_inicio' => \Carbon\Carbon::today()->addDays(30)->toDateString(), 'nro_cuota' => 2, 'total' => 150, 'actualizacion_punitorios' => null]);
            $cuota3 = factory(\App\Cuota::class)->create(['id_venta' => $ventaAf2->id, 'pagado' => 0, 'capital' => 100, 'interes' => 50, 'fecha_vto' => \Carbon\Carbon::today()->addDays(90)->toDateString(),'fecha_calculo' => \Carbon\Carbon::today()->addDays(90)->toDateString(), 'fecha_inicio' => \Carbon\Carbon::today()->addDays(60)->toDateString(), 'nro_cuota' => 3, 'total' => 150, 'actualizacion_punitorios' => null]);

            $afi3 = factory(\App\Afiliado::class)->create();
            factory(\App\CuotaSocial::class)->create(['id_afiliado' => $afi3->id, 'total' => 100, 'pagado' => 0, 'fecha_pago' => null]);

            $ventaAf3 = factory(\App\Venta::class)->create(['id_afiliado' => $afi3->id, 'id_farmacia' => 1, 'nro_cuotas' => 3]);
            $cuota1 = factory(\App\Cuota::class)->create(['id_venta' => $ventaAf3->id,'pagado' => 0, 'capital' => 100, 'interes' => 50, 'fecha_vto' => \Carbon\Carbon::today()->subDays(5)->toDateString(), 'fecha_inicio' => \Carbon\Carbon::today()->toDateString(), 'nro_cuota' => 1, 'total' => 150, 'actualizacion_punitorios' => null, 'fecha_calculo' => \Carbon\Carbon::today()->subDays(5)->toDateString()]);
            $cuota2 = factory(\App\Cuota::class)->create(['id_venta' => $ventaAf3->id,'pagado' => 0, 'capital' => 100, 'interes' => 50, 'fecha_vto' => \Carbon\Carbon::today()->addDays(60)->toDateString(), 'fecha_calculo' => \Carbon\Carbon::today()->addDays(60)->toDateString(), 'fecha_inicio' => \Carbon\Carbon::today()->addDays(30)->toDateString(), 'nro_cuota' => 2, 'total' => 150, 'actualizacion_punitorios' => null]);
            $cuota3 = factory(\App\Cuota::class)->create(['id_venta' => $ventaAf3->id, 'pagado' => 0, 'capital' => 100, 'interes' => 50, 'fecha_vto' => \Carbon\Carbon::today()->addDays(90)->toDateString(),'fecha_calculo' => \Carbon\Carbon::today()->addDays(90)->toDateString(), 'fecha_inicio' => \Carbon\Carbon::today()->addDays(60)->toDateString(), 'nro_cuota' => 3, 'total' => 150, 'actualizacion_punitorios' => null]);
            $ventaAf3->productos()->attach([1,2]);

            $ventaAf4 = factory(\App\Venta::class)->create(['id_afiliado' => $afi3->id, 'id_farmacia' => 1, 'nro_cuotas' => 3]);
            $cuota1 = factory(\App\Cuota::class)->create(['id_venta' => $ventaAf4->id,'pagado' => 0, 'capital' => 100, 'interes' => 50, 'fecha_vto' => \Carbon\Carbon::today()->subDays(5)->toDateString(),'fecha_calculo' => \Carbon\Carbon::today()->subDays(5)->toDateString(), 'fecha_inicio' => \Carbon\Carbon::today()->toDateString(), 'nro_cuota' => 1, 'total' => 150, 'actualizacion_punitorios' => null]);
            $cuota2 = factory(\App\Cuota::class)->create(['id_venta' => $ventaAf4->id,'pagado' => 0, 'capital' => 100, 'interes' => 50, 'fecha_vto' => \Carbon\Carbon::today()->addDays(60)->toDateString(),'fecha_calculo' => \Carbon\Carbon::today()->addDays(60)->toDateString(), 'fecha_inicio' => \Carbon\Carbon::today()->addDays(30)->toDateString(), 'nro_cuota' => 2, 'total' => 150, 'actualizacion_punitorios' => null]);
            $cuota3 = factory(\App\Cuota::class)->create(['id_venta' => $ventaAf4->id, 'pagado' => 0, 'capital' => 100, 'interes' => 50, 'fecha_vto' => \Carbon\Carbon::today()->addDays(90)->toDateString(),'fecha_calculo' => \Carbon\Carbon::today()->addDays(90)->toDateString(), 'fecha_inicio' => \Carbon\Carbon::today()->addDays(60)->toDateString(), 'nro_cuota' => 3, 'total' => 150, 'actualizacion_punitorios' => null]);
            $ventaAf4->productos()->attach([1,2]);





        });
    }
}
