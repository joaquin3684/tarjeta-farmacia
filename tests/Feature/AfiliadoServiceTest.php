<?php

namespace Tests\Feature;

use App\Afiliado;
use App\Perfiles;
use App\services\AfiliadoService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AfiliadoServiceTest extends TestCase
{
    use DatabaseMigrations;

    private $service;
    public function setUp()
    {
        parent::setUp();
        $this->service = new AfiliadoService();
        $this->artisan('migrate', ['--database' => 'mysql_testing']);
        $this->artisan('db:seed', ['--class' => 'SeguridadSeeder', '--database' => 'mysql_testing']);
        $this->artisan('db:seed', ['--class' => 'ObraSocialSeeder', '--database' => 'mysql_testing']);

    }

    public function testAltaAfiliado()
    {
        $afiliado = factory(Afiliado::class)->make()->toArray();
        $this->service->crear($afiliado);

        $afiliado['id_usuario'] = 4;
        $this->assertDatabaseHas('afiliados', $afiliado);
        $this->assertDatabaseHas('usuarios', ['name' => $afiliado['dni'], 'email' => $afiliado['email'], 'id_perfil' => Perfiles::AFILIADO]);
    }


    public function testUpdateAfiliado()
    {
        $afiliado = factory(Afiliado::class)->create();
        $afiliado2['id_usuario'] = 4;
        $afiliado2 = factory(Afiliado::class)->make()->toArray();
        $this->service->update($afiliado2, $afiliado->id);

        $this->assertDatabaseHas('afiliados', $afiliado2);
        $this->assertDatabaseHas('usuarios', ['name' => $afiliado2['dni'], 'email' => $afiliado2['email'], 'id_perfil' => Perfiles::AFILIADO]);

    }

    public function testFindAfiliado()
    {
        factory(Afiliado::class, 3)->create();
        $afiliado = $this->service->find(1);

        $this->assertEquals(true, !is_null($afiliado));
    }

    public function testAllAfiliado()
    {
        factory(Afiliado::class, 3)->create();
        $afiliado = $this->service->all();

        $this->assertEquals(3, $afiliado->count());
    }

    public function testDeleteAfiliado()
    {
        factory(Afiliado::class, 3)->create();
        $this->service->delete(1);
        $this->assertSoftDeleted('afiliados', ['id' => 1]);
    }

    public function testCuentaCorrienteAfiliadoEnEspecifico()
    {
        $this->artisan('db:seed', ['--class' => 'CobroSeederTest', '--database' => 'mysql_testing']);
        $c = $this->service->cuentaCorriente(1);
        $this->assertEquals(true, !is_null($c));

    }

    public function testCuentaCorrienteDeTodosLosAfiliados()
    {
        $this->artisan('db:seed', ['--class' => 'CobroSeederTest', '--database' => 'mysql_testing']);
        $c = $this->service->cuentaCorrienteAfiliados();
        $this->assertEquals(true, !is_null($c));
    }
}
