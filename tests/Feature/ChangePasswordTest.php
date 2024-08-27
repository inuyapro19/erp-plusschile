<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ChangePasswordTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    //use RefreshDatabase; // Si quieres resetear la base de datos después de cada test
    // use WithoutMiddleware; // Descomenta esta línea si necesitas desactivar el middleware durante las pruebas

    public function testChangePassword()
    {
        // Crear un usuario de prueba
        $user = User::create([
            'rut' => '12345678-9',
            'name' => 'Test User',
            'apellidos' => 'Test Apellidos',
            'email' => 'test@test.cl',
            'password' => bcrypt('1233456789')
        ]);

        // Autenticar como el usuario de prueba
        $this->actingAs($user);

        // Datos de la solicitud
        $payload = [
            'password' => 'alpaca123',
            'password_confirmation' => 'alpaca123',
        ];

        // Enviar solicitud de cambio de contraseña
        $response = $this->json('POST', '/profile/changepassword', $payload);

        // Afirmar que la contraseña ha sido cambiada
        $user->refresh(); // Recargar el usuario de la base de datos
        $this->assertTrue(Hash::check('alpaca123', $user->password));

        // Afirmar que la respuesta es la esperada
        $response->assertStatus(200)
            ->assertJson(['message' => 'Password updated successfully']);
    }
}
