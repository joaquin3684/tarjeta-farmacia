<?php

namespace Tests\Feature;

use App\Producto;
use App\services\ProductoService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductoServiceTest extends TestCase
{
    use DatabaseMigrations;

    private $service;
    public function setUp()
    {
        parent::setUp();
        $this->service = new ProductoService();
        $this->artisan('migrate', ['--database' => 'mysql_testing']);
        $this->artisan('db:seed', ['--class' => 'RedSeeder', '--database' => 'mysql_testing']);

    }

    public function testAltaProducto()
    {
        $producto = factory(Producto::class)->make()->toArray();
        $this->service->crear($producto);


        $this->assertDatabaseHas('productos', $producto);
    }


    public function testUpdateProducto()
    {
        $producto = factory(Producto::class)->create();
        $producto2 = factory(Producto::class)->make()->toArray();
        $this->service->update($producto2, $producto->id);


        $this->assertDatabaseHas('productos', $producto2);

    }

    public function testFindProducto()
    {
        factory(Producto::class, 3)->create();
        $producto = $this->service->find(1);

        $this->assertEquals(true, !is_null($producto));
    }

    public function testAllProducto()
    {
        factory(Producto::class, 3)->create();
        $producto = $this->service->all();

        $this->assertEquals(3, $producto->count());
    }

    public function testDeleteProducto()
    {
        factory(Producto::class, 3)->create();
        $this->service->delete(1);
        $this->assertSoftDeleted('productos', ['id' => 1]);
    }
}
