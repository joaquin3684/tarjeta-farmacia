<?php

namespace Tests\Feature;

use App\ObraSocial;
use App\services\ObraSocialService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ObraSocialServiceTest extends TestCase
{
    use DatabaseMigrations;

    private $service;
    public function setUp()
    {
        parent::setUp();
        $this->service = new ObraSocialService();
        $this->artisan('migrate', ['--database' => 'mysql_testing']);
    }

    public function testAltaObraSocial()
    {
        $obraSocial = factory(ObraSocial::class)->make()->toArray();
        $this->service->crear($obraSocial);


        $this->assertDatabaseHas('obras_sociales', $obraSocial);
    }


    public function testUpdateObraSocial()
    {
        $obraSocial = factory(ObraSocial::class)->create();
        $obraSocial2 = factory(ObraSocial::class)->make()->toArray();
        $this->service->update($obraSocial2, $obraSocial->id);

        $this->assertDatabaseHas('obras_sociales', $obraSocial2);

    }

    public function testFindObraSocial()
    {
        factory(ObraSocial::class, 3)->create();
        $obraSocial = $this->service->find(1);

        $this->assertEquals(true, !is_null($obraSocial));
    }

    public function testAllObraSocial()
    {
        factory(ObraSocial::class, 3)->create();
        $obraSocial = $this->service->all();

        $this->assertEquals(3, $obraSocial->count());
    }

    public function testDeleteObraSocial()
    {
        factory(ObraSocial::class, 3)->create();
        $this->service->delete(1);
        $this->assertSoftDeleted('obras_sociales', ['id' => 1]);
    }
}
