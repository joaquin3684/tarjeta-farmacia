<?php

namespace Tests\Feature;

use App\Afiliado;
use App\EstadoSolicitud;
use App\Producto;
use App\services\AfiliadoService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CompraDeAfiliadoTest extends TestCase
{
    use DatabaseMigrations;

    private $service;
    public function setUp()
    {
        parent::setUp();
        $this->service = new AfiliadoService();
        $this->artisan('migrate', ['--database' => 'mysql_testing']);
        $this->artisan('db:seed', ['--class' => 'SeguridadSeeder', '--database' => 'mysql_testing']);
        $this->artisan('db:seed', ['--class' => 'FarmaciaSeeder', '--database' => 'mysql_testing']);
        $this->artisan('db:seed', ['--class' => 'ProductoSeeder', '--database' => 'mysql_testing']);
        $this->artisan('db:seed', ['--class' => 'ObraSocialSeeder', '--database' => 'mysql_testing']);
    }

    public function testCompraConMasDeDosProductos()
    {
        $afiliado = factory(Afiliado::class)->create(['limite_credito' => 5000]);

        $res = $this->service->compra(['idAfiliado' => $afiliado->id, 'idFarmacia' => 1, 'nroCuotas' => 3, 'productos'=> [1,2,3]]);

        $this->assertEquals(0, $res);

    }

    public function testCompraSinCreditoDeRedDisponible()
    {
        $afiliado = factory(Afiliado::class)->create(['limite_credito' => 10000]);
        $prod = factory(Producto::class)->create(['precio' => 8000, 'id_red' => 1]);
        $res = $this->service->compra(['idAfiliado' => $afiliado->id, 'idFarmacia' => 1, 'nroCuotas' => 3, 'productos'=> [$prod->id]]);
        $this->assertEquals(0, $res);

    }

    public function testCompraSinCreditoDeAfiliadoDisponible()
    {
        $afiliado = factory(Afiliado::class)->create(['limite_credito' => 1]);
        $res = $this->service->compra(['idAfiliado' => $afiliado->id, 'idFarmacia' => 1, 'nroCuotas' => 3, 'productos'=> [1,2]]);
        $this->assertEquals(0, $res);
    }

    public function testCompraRealizada()
    {
        $afiliado = factory(Afiliado::class)->create(['limite_credito' => 10000]);
        $prod = factory(Producto::class)->create(['precio' => 2000, 'id_red' => 1]);
        $prod2 = factory(Producto::class)->create(['precio' => 1000, 'id_red' => 1]);

        $res = $this->service->compra(['idAfiliado' => $afiliado->id, 'idFarmacia' => 1, 'nroCuotas' => 3, 'productos'=> [$prod->id,$prod2->id]]);
        $this->assertDatabaseHas('solicitudes', ['fecha' => Carbon::now()->toDateTimeString(), 'monto' => 3000, 'nro_cuotas' => 3, 'id_afiliado' => $afiliado->id, 'id_farmacia' => 1, 'estado' => EstadoSolicitud::PENDIENTE]);
        $this->assertDatabaseHas('solicitud_producto', ['id_solicitud' => 1, 'id_producto' => $prod2->id]);
        $this->assertDatabaseHas('solicitud_producto', ['id_solicitud' => 1, 'id_producto' => $prod->id]);
    }
}
