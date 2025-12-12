<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Game;

class GameTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test que se pueden listar todos los juegos
     */
    public function test_can_list_all_games(): void
    {
        // Crear 3 juegos de prueba usando factory
        Game::factory()->count(3)->create();

        // Hacer petición GET
        $response = $this->getJson('/api/games');

        // Verificar respuesta
        $response->assertStatus(200)
                 ->assertJsonCount(3);
    }

    /**
     * Test que se puede crear un juego
     */
    public function test_can_create_game(): void
    {
        $gameData = [
            'title' => 'The Legend of Zelda',
            'description' => 'Epic adventure game',
            'genre' => 'Adventure',
            'platform' => 'Nintendo Switch'
        ];

        $response = $this->postJson('/api/games', $gameData);

        $response->assertStatus(201)
                 ->assertJsonFragment(['title' => 'The Legend of Zelda'])
                 ->assertJsonStructure([
                     'id',
                     'title',
                     'description',
                     'genre',
                     'platform',
                     'created_at',
                     'updated_at'
                 ]);

        // Verificar que está en la base de datos
        $this->assertDatabaseHas('games', [
            'title' => 'The Legend of Zelda',
            'genre' => 'Adventure'
        ]);
    }

    /**
     * Test que falla al crear juego sin datos requeridos
     */
    public function test_cannot_create_game_without_required_fields(): void
    {
        $response = $this->postJson('/api/games', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['title', 'description', 'genre', 'platform']);
    }

    /**
     * Test que no se puede crear juego con título duplicado
     */
    public function test_cannot_create_game_with_duplicate_title(): void
    {
        // Crear un juego
        Game::factory()->create(['title' => 'Duplicate Game']);

        // Intentar crear otro con el mismo título
        $response = $this->postJson('/api/games', [
            'title' => 'Duplicate Game',
            'description' => 'Test description',
            'genre' => 'Action',
            'platform' => 'PC'
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['title']);
    }

    /**
     * Test que se puede obtener un juego específico
     */
    public function test_can_show_single_game(): void
    {
        $game = Game::factory()->create([
            'title' => 'Test Game'
        ]);

        $response = $this->getJson("/api/games/{$game->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'id' => $game->id,
                     'title' => 'Test Game'
                 ]);
    }

    /**
     * Test que retorna 404 si el juego no existe
     */
    public function test_returns_404_when_game_not_found(): void
    {
        $response = $this->getJson('/api/games/999');

        $response->assertStatus(404);
    }

    /**
     * Test que se puede actualizar un juego
     */
    public function test_can_update_game(): void
    {
        $game = Game::factory()->create([
            'title' => 'Original Title'
        ]);

        $updateData = [
            'title' => 'Updated Title',
            'genre' => 'RPG'
        ];

        $response = $this->putJson("/api/games/{$game->id}", $updateData);

        $response->assertStatus(200)
                 ->assertJsonFragment(['title' => 'Updated Title']);

        // Verificar en base de datos
        $this->assertDatabaseHas('games', [
            'id' => $game->id,
            'title' => 'Updated Title',
            'genre' => 'RPG'
        ]);
    }

    /**
     * Test que se puede eliminar un juego
     */
    public function test_can_delete_game(): void
    {
        $game = Game::factory()->create();

        $response = $this->deleteJson("/api/games/{$game->id}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Juego eliminado correctamente']);

        // Verificar que fue eliminado
        $this->assertDatabaseMissing('games', ['id' => $game->id]);
    }

    /**
     * Test que la lista está vacía inicialmente
     */
    public function test_empty_list_returns_empty_array(): void
    {
        $response = $this->getJson('/api/games');

        $response->assertStatus(200)
                 ->assertJson([]);
    }
}
