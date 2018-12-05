<?php

namespace Tests\Feature;

use App\ConfigMutual;
use App\EstadoSolicitud;
use App\services\SolicitudService;
use App\Solicitud;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SolicitudServiceTest extends TestCase
{
    use DatabaseMigrations;

    private $service;
    public function setUp()
    {
        parent::setUp();
        $this->service = new SolicitudService();
        $this->artisan('migrate', ['--database' => 'mysql_testing']);
        $this->artisan('db:seed', ['--class' => 'SeguridadSeeder', '--database' => 'mysql_testing']);
        $this->artisan('db:seed', ['--class' => 'FarmaciaSeeder', '--database' => 'mysql_testing']);
        $this->artisan('db:seed', ['--class' => 'AfiliadoSeeder', '--database' => 'mysql_testing']);
        $this->artisan('db:seed', ['--class' => 'ProductoSeeder', '--database' => 'mysql_testing']);


    }

    public function testAceptarSolicitud()
    {
        $solicitud = factory(Solicitud::class)->create(['nro_cuotas' => 3]);
        $solicitud->productos()->attach([1,2]);
        $this->service->aceptar(['id' => $solicitud->id]);

        $this->assertDatabaseHas('ventas', [
                    'fecha' =>  Carbon::now()->toDateTimeString(),
                    'capital_total' => $solicitud->monto,
                    'interes_total' => round($solicitud->monto * ConfigMutual::INTERES / 100,2),
                    'nro_cuotas' => $solicitud->nro_cuotas,
                    'id_afiliado' =>  $solicitud->id_afiliado,
                    'id_farmacia' => $solicitud->id_farmacia
                ]);
        $this->assertDatabaseHas('venta_producto', ['id_venta' => 1, 'id_producto' => 1]);
        $this->assertDatabaseHas('venta_producto', ['id_venta' => 1, 'id_producto' => 2]);
        $this->assertDatabaseHas('cuotas', [
                                'id_venta' => 1,
                                'capital' => round($solicitud->monto/3, 2),
                                'interes' => round($solicitud->monto * ConfigMutual::INTERES / 100 / 3,2),
                                'interes_punitorio' => 0,
                                'fecha_vto' => Carbon::today()->addDays(30)->toDateString(),
                                'fecha_inicio' => Carbon::today()->toDateString(),
                                'nro_cuota' => 1
        ]);
        $this->assertDatabaseHas('cuotas', [
                                'id_venta' => 1,
                                'capital' => round($solicitud->monto/3, 2),
                                'interes' => round($solicitud->monto * ConfigMutual::INTERES / 100 / 3,2),
                                'interes_punitorio' => 0,
                                'fecha_vto' => Carbon::today()->addDays(60)->toDateString(),
                                'fecha_inicio' => Carbon::today()->addDays(30)->toDateString(),
                                'nro_cuota' => 2
        ]);
        $this->assertDatabaseHas('cuotas', [
                                'id_venta' => 1,
                                'capital' => round($solicitud->monto/3, 2),
                                'interes' => round($solicitud->monto * ConfigMutual::INTERES / 100 / 3,2),
                                'interes_punitorio' => 0,
                                'fecha_vto' => Carbon::today()->addDays(90)->toDateString(),
                                'fecha_inicio' => Carbon::today()->addDays(60)->toDateString(),
                                'nro_cuota' => 3
        ]);

        $this->assertDatabaseHas('solicitudes', ['id' => $solicitud->id, 'estado' => EstadoSolicitud::CONFIRMADO]);

        $this->assertDatabaseHas('redes', ['id' => 1, 'credito' => 4900]);

    }

    public function testRechazarSolicitud()
    {
        $solicitud = factory(Solicitud::class)->create(['nro_cuotas' => 3]);
        $solicitud->productos()->attach([1,2]);
        $this->service->rechazar(['id' => $solicitud->id, 'observacion' => 'no quiero']);
        $this->assertDatabaseHas('solicitudes', ['id' => $solicitud->id, 'estado' => EstadoSolicitud::RECHAZADO, 'observacion' => 'no quiero']);

    }

    public function testAll()
    {
        $solicitud = factory(Solicitud::class)->create(['nro_cuotas' => 3]);
        $solicitud->productos()->attach([1,2]);

        $solicitudes = $this->service->all();
        $this->assertEquals(1, $solicitudes->count());
    }
}
