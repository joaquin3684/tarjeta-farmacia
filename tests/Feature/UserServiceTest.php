<?php

namespace Tests\Feature;

use App\services\UserService;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserServiceTest extends TestCase
{
    use DatabaseMigrations;

    private $service;
    public function setUp()
    {
        parent::setUp();
        $this->service = new UserService();
        $this->artisan('migrate', ['--database' => 'mysql_testing']);
        $this->artisan('db:seed', ['--class' => 'SeguridadSeeder', '--database' => 'mysql_testing']);

    }

    public function testAltaUser()
    {
        $user = factory(User::class)->make()->toArray();
        $user['password'] = 1;
        $this->service->crear($user);
        unset($user['password']);
        $this->assertDatabaseHas('usuarios', $user);
    }


    public function testUpdateUser()
    {
        $user = factory(User::class)->create(['password' => Hash::make('prueba')]);
        $user2 = factory(User::class)->make()->toArray();
        unset($user2['password']);
        $this->service->update($user2, $user->id);

        $this->assertDatabaseHas('usuarios', $user2);

    }

    public function testFindUser()
    {
        factory(User::class)->create(['password' => Hash::make('prueba')]);
        $user = $this->service->find(1);

        $this->assertEquals(true, !is_null($user));
    }

    public function testAllUser()
    {
        $user = $this->service->all();

        $this->assertEquals(3, $user->count());
    }

    public function testDeleteUser()
    {
        $this->service->delete(1);
        $this->assertSoftDeleted('usuarios', ['id' => 1]);
    }

    public function testcambiarPasswors()
    {
        $this->service->cambiarPassword(['password' => 'pepe', 'id' => 1]);

        $user = $this->service->find(1);
        $this->assertEquals(true, Hash::check('pepe', $user->password));
    }

    public function testPerfiles()
    {
        $perf = $this->service->perfiles();
        $this->assertEquals(3, $perf->count());
    }
}
