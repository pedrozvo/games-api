<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    // 1. GET /api/games (Listar todos)
    public function index()
    {
        return response()->json(Game::all(), 200);
    }

    // 2. POST /api/games (Crear uno nuevo)
    public function store(Request $request)
    {
        // Validación simple
        $request->validate([
            'title' => 'required',
            'genre' => 'required',
            'platform' => 'required'
        ]);

        // Crear juego
        $game = Game::create($request->all());

        return response()->json($game, 201);
    }

    // 3. GET /api/games/{id} (Obtener por ID)
    public function show($id)
    {
        $game = Game::find($id);

        if (!$game) {
            return response()->json(['message' => 'Juego no encontrado'], 404);
        }

        return response()->json($game, 200);
    }

    // 4. PUT /api/games/{id} (Actualizar)
    public function update(Request $request, $id)
    {
        $game = Game::find($id);

        if (!$game) {
            return response()->json(['message' => 'Juego no encontrado'], 404);
        }

        // Validación
        $request->validate([
            'title' => 'sometimes|required',
            'genre' => 'sometimes|required',
            'platform' => 'sometimes|required',
            'description' => 'nullable'
        ]);

        // Actualizar
        $game->update($request->all());

        return response()->json($game, 200);
    }

    // 5. DELETE /api/games/{id} (Eliminar)
    public function destroy($id)
    {
        $game = Game::find($id);

        if (!$game) {
            return response()->json(['message' => 'Juego no encontrado'], 404);
        }

        $game->delete();

        return response()->json(['message' => 'Juego eliminado correctamente'], 200);
    }
}