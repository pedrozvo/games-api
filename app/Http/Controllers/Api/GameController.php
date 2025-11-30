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
}