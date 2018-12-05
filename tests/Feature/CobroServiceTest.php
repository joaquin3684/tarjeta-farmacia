<?php

namespace Tests\Feature;

use App\Afiliado;
use App\services\CobroService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CobroServiceTest extends TestCase
{
    use DatabaseMigrations;

    private $service;
    public function setUp()
    {
        parent::setUp();
        $this->service = new CobroService();
        $this->artisan('migrate:refresh', ['--database' => 'mysql_testing']);
        $this->artisan('db:seed', ['--class' => 'SeguridadSeeder', '--database' => 'mysql_testing']);
        $this->artisan('db:seed', ['--class' => 'CobroSeederTest', '--database' => 'mysql_testing']);
    }

    public function testCobrarSoloCuotaSocial()
    {

        $this->service->cobro([['id' => 1, 'monto' => 100]]);

        $this->assertDatabaseMissing('movimientos', ['id' => 1]);
        $this->assertDatabaseHas('cuotas_sociales', ['id_afiliado' => 1, 'total' => 100, 'pagado' => 100, 'fecha_pago' => Carbon::today()->toDateString()]);
    }

    public function testCobrarCuotaSocialMasUnaParcial()
    {

        $this->service->cobro([['id' => 1, 'monto' => 200]]);

        $this->assertDatabaseHas('cuotas_sociales', ['id_afiliado' => 1, 'total' => 100, 'pagado' => 100, 'fecha_pago' => Carbon::today()->toDateString()]);
        $this->assertDatabaseHas('cuotas', ['nro_cuota' => 1, 'pagado' => 100]);
        $this->assertDatabaseHas('movimientos', ['id_cuota' => 1, 'ingreso' => 100, 'fecha' => Carbon::today()->toDateString()]);
        $this->assertDatabaseHas('cuotas', ['nro_cuota' => 2, 'pagado' => 0]);
    }

    public function testCobrarCuotaSocialMasDosCuotasDebidas()
    {
        $this->service->cobro([['id' => 1, 'monto' => 400]]);

        $this->assertDatabaseHas('cuotas_sociales', ['id_afiliado' => 1, 'total' => 100, 'pagado' => 100, 'fecha_pago' => Carbon::today()->toDateString()]);
        $this->assertDatabaseHas('cuotas', ['nro_cuota' => 1, 'pagado' => 150]);
        $this->assertDatabaseHas('cuotas', ['nro_cuota' => 2, 'pagado' => 150]);
        $this->assertDatabaseHas('movimientos', ['id_cuota' => 1, 'ingreso' => 150, 'fecha' => Carbon::today()->toDateString()]);
        $this->assertDatabaseHas('movimientos', ['id_cuota' => 2, 'ingreso' => 150, 'fecha' => Carbon::today()->toDateString()]);

    }

    public function testCobrar2CuotaSocialesMasDosCuotasDebidas()
    {
        $this->service->cobro([['id' => 2, 'monto' => 500]]);

        $this->assertDatabaseHas('cuotas_sociales', ['id_afiliado' => 2, 'total' => 100, 'pagado' => 100, 'fecha_pago' => Carbon::today()->toDateString(), 'nro_cuota' => 1]);
        $this->assertDatabaseHas('cuotas_sociales', ['id_afiliado' => 2, 'total' => 100, 'pagado' => 100, 'fecha_pago' => Carbon::today()->toDateString(), 'nro_cuota' => 2]);
        $this->assertDatabaseHas('cuotas', ['nro_cuota' => 1, 'pagado' => 150]);
        $this->assertDatabaseHas('cuotas', ['nro_cuota' => 2, 'pagado' => 150]);
        $this->assertDatabaseHas('movimientos', ['id_cuota' => 4, 'ingreso' => 150, 'fecha' => Carbon::today()->toDateString()]);
        $this->assertDatabaseHas('movimientos', ['id_cuota' => 5, 'ingreso' => 150, 'fecha' => Carbon::today()->toDateString()]);

    }

    public function testCobrar1CuotaSocialMasDosCuotasDeDosVentasDistintiasConPunitorios()
    {
        $this->service->cobro([['id' => 3, 'monto' => 350]]);

        $this->assertDatabaseHas('cuotas_sociales', ['id_afiliado' => 3, 'total' => 100, 'pagado' => 100, 'fecha_pago' => Carbon::today()->toDateString(), 'nro_cuota' => 1]);
        $this->assertDatabaseHas('cuotas', ['nro_cuota' => 1, 'pagado' => 180, 'id_venta' => 3]);
        $this->assertDatabaseHas('cuotas', ['nro_cuota' => 1, 'pagado' => 70, 'id_venta' => 4, 'fecha_calculo' => Carbon::today()->toDateString()]);
        $this->assertDatabaseHas('movimientos', ['id_cuota' => 7, 'ingreso' => 180, 'fecha' => Carbon::today()->toDateString()]);
        $this->assertDatabaseHas('movimientos', ['id_cuota' => 10, 'ingreso' => 70, 'fecha' => Carbon::today()->toDateString()]);
    }

    public function testActualizarPunitoriosAfiliadoSinMora()
    {
        $list = $this->service->listadoDeCobros();

        $list->each(function($afi){
            $afi->ventas->each(function($venta){
                $venta->cuotas->each(function($cuota){
                    if(Carbon::today()->diffInDays(Carbon::createFromFormat('Y-m-d', $cuota['fecha_calculo']), false) < 0)
                    {
                        $this->assertEquals(180, $cuota['total']);
                        $this->assertEquals(30, $cuota['interes_punitorio']);
                    }
                    else
                    {
                        $this->assertEquals(150, $cuota['total']);
                        $this->assertEquals(0, $cuota['interes_punitorio']);
                    }
                });
            });
        });



    }


}
