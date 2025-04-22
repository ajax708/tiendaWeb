<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_creation_via_factory(): void
    {
        // Crea un user en DB en memoria
        $user = User::factory()->create([
            'name'     => 'Usuario Prueba',
            'email'    => 'prueba@example.com',
            'password' => bcrypt('secret'),
        ]);

        // Verifica que exista en la tabla users
        $this->assertDatabaseHas('users', [
            'email' => 'prueba@example.com',
        ]);

        // Verifica que el nombre sea idéntico
        $this->assertSame('Usuario Prueba', $user->name);
    }
}
