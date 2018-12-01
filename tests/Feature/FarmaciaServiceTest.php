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

    }

    public function testAltaFarmacia()
    {
        $a = new FarmaciaService();
        $farmacia = factory(Farmacia::class)->make()->toArray();
        $this->service->crear($farmacia);

        $this->assertDatabaseHas('farmacias', $farmacia);
        $this->assertDatabaseHas('usuarios', ['name' => $farmacia['nombre'], 'password' => Hash::make($farmacia['nombre']), 'email' => $farmacia['email'], 'id_perfil' => Perfiles::FARMACIA]);
    }

}
