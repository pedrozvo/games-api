<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGameRequest;
use App\Http\Requests\UpdateGameRequest;
use App\Models\Game;
use Illuminate\Http\JsonResponse;

class GameController extends Controller
{
    /**
     * Display a listing of the games.
     */
    public function index(): JsonResponse
    {
        $games = Game::all();

        return response()->json($games, 200);
    }

    /**
     * Store a newly created game in storage.
     */
    public function store(StoreGameRequest $request): JsonResponse
    {
        $game = Game::create($request->validated());

        return response()->json($game, 201);
    }

    /**
     * Display the specified game.
     */
    public function show(Game $game): JsonResponse
    {
        return response()->json($game, 200);
    }

    /**
     * Update the specified game in storage.
     */
    public function update(UpdateGameRequest $request, Game $game): JsonResponse
    {
        $game->update($request->validated());

        return response()->json($game, 200);
    }

    /**
     * Remove the specified game from storage.
     */
    public function destroy(Game $game): JsonResponse
    {
        $game->delete();

        return response()->json([
            'message' => 'Juego eliminado correctamente',
        ], 200);
    }
}
