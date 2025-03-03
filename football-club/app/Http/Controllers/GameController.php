<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Services\Contracts\IGameService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\Serializer\Serializer;

class GameController extends Controller
{
    private IGameService $_gameService;
    private Serializer $serializer;

    public function __construct(IGameService $gameService, Serializer $serializer)
    {
        $this->_gameService = $gameService;
        $this->serializer = $serializer;
    }

    public function index(): JsonResponse|View
    {
        try {
            $games = $this->_gameService->getAll();

            if ($games->isEmpty()) {
                if (request()->expectsJson()) {
                    return response()->json(['message' => 'No games found'], 404);
                } else {
                    return view('games.index', ['games' => $games, 'message' => 'No games found']);
                }
            }

            if (request()->expectsJson()) {
                return response()->json($games);
            } else {
                return view('games.index', compact('games'));
            }
        } catch (Exception $e) {
            if (request()->expectsJson()) {
                return response()->json(['message' => 'Failed to retrieve games', 'error' => $e->getMessage()], 500);
            } else {
                return view('errors.general', ['message' => 'Failed to retrieve games', 'error' => $e->getMessage()]);
            }
        }
    }

    public function store(Request $request): JsonResponse|View
    {
        if ('json' !== $request->getContentTypeFormat()) {
            return response()->json(['message' => 'Unsupported content format'], 415);
        }

        $jsonData = $request->getContent();

        if (empty($jsonData) || is_null(json_decode($jsonData))) {
            return response()->json(['message' => 'Invalid JSON data'], 400);
        }

        try {
            $deserializedData = $this->serializer->deserialize($jsonData, Game::class, 'json');

            $game = $this->_gameService->create($deserializedData);

            return response()->json($game, 201);
        } catch (Exception $e) {
            if (request()->expectsJson()) {
                return response()->json(['message' => 'Failed to create game', 'error' => $e->getMessage()], 500);
            } else {
                return view('errors.general', ['message' => 'Failed to create game', 'error' => $e->getMessage()]);
            }
        }
    }

    public function show(Request $request, int $id): JsonResponse|View
    {
        try {
            if ($id <= 0) {
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Invalid ID provided'], 400);
                } else {
                    return view('errors.general', ['id' => $id]);
                }
            }

            $game = $this->_gameService->getById($id);

            if (!$game) {
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Game not found'], 404);
                } else {
                    return view('errors.general', ['id' => $id]);
                }
            }

            return response()->json($game);
        } catch (Exception $e) {
            if (request()->expectsJson()) {
                return response()->json(['message' => 'Failed to retrieve game', 'error' => $e->getMessage()], 500);
            } else {
                return view('errors.general', ['message' => 'Failed to retrieve game', 'error' => $e->getMessage()]);
            }
        }
    }

    public function update(Request $request, int $id): JsonResponse|View
    {
        if ('json' !== $request->getContentTypeFormat()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unsupported content format'], 415);
            } else {
                return view('errors.unsupported_format');
            }
        }

        $jsonData = $request->getContent();

        if (empty($jsonData) || is_null(json_decode($jsonData))) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Invalid JSON data'], 400);
            } else {
                return view('errors.invalid_json_data');
            }
        }

        try {
            $deserializedData = $this->serializer->deserialize($jsonData, Game::class, 'json');

            $game = $this->_gameService->update($id, $deserializedData);

            if (!$game) {
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Game not found'], 404);
                } else {
                    return view('errors.general', ['id' => $id]);
                }
            }

            if ($request->expectsJson()) {
                return response()->json($game);
            } else {
                return view('game.show', compact('game'));
            }
        } catch (Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Failed to update game', 'error' => $e->getMessage()], 500);
            } else {
                return view('errors.general', ['message' => 'Failed to update game', 'error' => $e->getMessage()]);
            }
        }
    }

    public function destroy(Request $request, int $id): JsonResponse|View
    {
        if ($id <= 0) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Invalid ID provided'], 400);
            } else {
                return view('errors.invalid_id', ['id' => $id]);
            }
        }

        try {
            $deleted = $this->_gameService->delete($id);

            if (!$deleted) {
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Game not found'], 404);
                } else {
                    return view('errors.general', ['message' => 'Failed to find game']);
                }
            }

            if ($request->expectsJson()) {
                return response()->json(['message' => 'Game deleted']);
            } else {
                return view('games.deleted', ['id' => $id]);
            }
        } catch (Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Failed to delete game', 'error' => $e->getMessage()], 500);
            } else {
                return view('errors.general', ['message' => 'Failed to delete game', 'error' => $e->getMessage()]);
            }
        }
    }
}

