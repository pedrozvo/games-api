<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Game;

class GameTest extends TestCase
{
    // Limpia la BD después de cada test para no dejar basura
    use RefreshDatabase;

    public function test_can_list_games()
    {
        //Creamos 1 juego de prueba en la BD
        Game::create([
            'title' => 'Test Game',
            'description' => 'Description test',
            'genre' => 'Action',
            'platform' => 'PC'
        ]);

        //Hacemos la petición GET /api/games
        $response = $this->getJson('/api/games');

        //Que la respuesta sea correcta y contenga el juego
        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'title' => 'Test Game'
                 ]);
    }
}