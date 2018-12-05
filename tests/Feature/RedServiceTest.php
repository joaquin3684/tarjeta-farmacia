<?php

namespace Tests\Feature;

use App\Red;
use App\services\RedService;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RedServiceTest extends TestCase
{
    use DatabaseMigrations;

    private $service;
    public function setUp()
    {
        parent::setUp();
        $this->service = new RedService();
        $this->artisan('migrate', ['--database' => 'mysql_testing']);
    }

    public function testAltaRed()
    {
        $red = factory(Red::class)->make()->toArray();
        $this->service->crear($red);


        $this->assertDatabaseHas('redes', $red);
    }


    public function testUpdateRed()
    {
        $red = factory(Red::class)->create();
        $red2 = factory(Red::class)->make()->toArray();
        $this->service->update($red2, $red->id);


        $this->assertDatabaseHas('redes', $red2);

    }

    public function testFindRed()
    {
        factory(Red::class, 3)->create();
        $red = $this->service->find(1);

        $this->assertEquals(true, !is_null($red));
    }

    public function testAllRed()
    {
        factory(Red::class, 3)->create();
        $red = $this->service->all();

        $this->assertEquals(3, $red->count());
    }

    public function testDeleteRed()
    {
        factory(Red::class, 3)->create();
        $this->service->delete(1);
        $this->assertSoftDeleted('redes', ['id' => 1]);
    }
}
