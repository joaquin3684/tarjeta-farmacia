<?php

namespace Tests\Feature;

use App\Farmacia;
use App\Perfiles;
use App\services\FarmaciaService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FarmaciaServiceTest extends TestCase
{
    use DatabaseMigrations;

    private $service;
    public function setUp()
    {
        parent::setUp();
        $this->service = new FarmaciaService();
        $this->artisan('migrate', ['--database' => 'mysql_testing']);
        $this->artisan('db:seed', ['--class' => 'SeguridadSeeder', '--database' => 'mysql_testing']);
        $this->artisan('db:seed', ['--class' => 'RedSeeder', '--database' => 'mysql_testing']);
    }

    public function testAltaFarmacia()
    {
        $farmacia = factory(Farmacia::class)->make()->toArray();
        $redes = [1];
        $farmacia['redes'] = $redes;
        $this->service->crear($farmacia);

        unset($farmacia['redes']);

        $farmacia['id_usuario'] = 4; //pongo id_usuario = 4 porque de la seed de seguridad ya hay creado 3 usuarios
        $this->assertDatabaseHas('farmacias', $farmacia);
        $this->assertDatabaseHas('red_farmacia', ['id_red' => 1, 'id_farmacia' => 1]);

        $this->assertDatabaseHas('usuarios', ['name' => $farmacia['nombre'], 'email' => $farmacia['email'], 'id_perfil' => Perfiles::FARMACIA]);
    }


    public function testUpdateFarmacia()
    {
        $farmacia = factory(Farmacia::class)->create();
        $farmacia2 = factory(Farmacia::class)->make()->toArray();
        $redes = [1,2];
        $farmacia2['redes'] = $redes;
        $this->service->update($farmacia2, $farmacia->id);

        unset($farmacia2['redes']);

        $farmacia['id_usuario'] = 4; //pongo id_usuario = 4 porque de la seed de seguridad ya hay creado 3 usuarios
        $this->assertDatabaseHas('farmacias', $farmacia2);
        $this->assertDatabaseHas('red_farmacia', ['id_red' => 1, 'id_farmacia' => 1]);
        $this->assertDatabaseHas('red_farmacia', ['id_red' => 2, 'id_farmacia' => 1]);

        $this->assertDatabaseHas('usuarios', ['name' => $farmacia2['nombre'], 'email' => $farmacia2['email'], 'id_perfil' => Perfiles::FARMACIA]);
    }

    public function testFindFarmacia()
    {
        factory(Farmacia::class, 3)->create()->each(function($farm){ $farm->redes()->attach(1);});
        $farmacia = $this->service->find(1);

        $this->assertEquals(true, !is_null($farmacia));
    }

    public function testAllFarmacia()
    {
        factory(Farmacia::class, 3)->create();
        $farmacia = $this->service->all();

        $this->assertEquals(3, $farmacia->count());
    }

    public function testDeleteFarmacia()
    {
        factory(Farmacia::class, 3)->create();
        $this->service->delete(1);
        $this->assertSoftDeleted('farmacias', ['id' => 1]);
    }
}
