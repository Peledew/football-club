<?php

namespace App\Http\Controllers;

use App\DTOs\PlayerDTO;
use App\Models\Player;
use App\Services\Contracts\IPlayerService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\Serializer\Serializer;

class PlayerController extends Controller
{
    private IPlayerService $_playerService;
    private Serializer $serializer;

    public function __construct(IPlayerService $playerService, Serializer $serializer)
    {
        $this->_playerService = $playerService;
        $this->serializer = $serializer;
    }

    public function index(): JsonResponse|View
    {
        try {
            $players = $this->_playerService->getAll();

            if ($players->isEmpty()) {
                if (request()->expectsJson()) {
                    return response()->json(['message' => 'No players found'], 404);
                } else {
                    return view('players.index', ['players' => $players, 'message' => 'No players found']);
                }
            }

            if (request()->expectsJson()) {
                return response()->json($players);
            } else {
                return view('players.index', compact('players'));
            }
        } catch (Exception $e) {
            if (request()->expectsJson()) {
                return response()->json(['message' => 'Failed to retrieve players', 'error' => $e->getMessage()], 500);
            } else {
                return view('errors.general', ['message' => 'Failed to retrieve players', 'error' => $e->getMessage()]);
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
            $deserializedData = $this->serializer->deserialize($jsonData, PlayerDTO::class, 'json');

            $player = $this->_playerService->create($deserializedData);

            return response()->json($player, 201);
        } catch (Exception $e) {
            if (request()->expectsJson()) {
                return response()->json(['message' => 'Failed to create player', 'error' => $e->getMessage()], 500);
            } else {
                return view('errors.general', ['message' => 'Failed to create player', 'error' => $e->getMessage()]);
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

            $player = $this->_playerService->getById($id);

            if (!$player) {
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Player not found'], 404);
                } else {
                    return view('errors.general', ['id' => $id]);
                }
            }

            return response()->json($player);
        } catch (Exception $e) {
            if (request()->expectsJson()) {
                return response()->json(['message' => 'Failed to retrieve player', 'error' => $e->getMessage()], 500);
            } else {
                return view('errors.general', ['message' => 'Failed to retrieve player', 'error' => $e->getMessage()]);
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
            $deserializedData = $this->serializer->deserialize($jsonData, Player::class, 'json');

            $player = $this->_playerService->update($id, $deserializedData);

            if (!$player) {
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Player not found'], 404);
                } else {
                    return view('errors.general', ['id' => $id]);
                }
            }

            if ($request->expectsJson()) {
                return response()->json($player);
            } else {
                return view('players.show', compact('player'));
            }
        } catch (Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Failed to update player', 'error' => $e->getMessage()], 500);
            } else {
                return view('errors.general', ['message' => 'Failed to update player', 'error' => $e->getMessage()]);
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
            $deleted = $this->_playerService->delete($id);

            if (!$deleted) {
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Player not found'], 404);
                } else {
                    return view('errors.general', ['message' => 'Failed to find player']);
                }
            }

            if ($request->expectsJson()) {
                return response()->json(['message' => 'Player deleted']);
            } else {
                return view('players.deleted', ['id' => $id]);
            }
        } catch (Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Failed to delete player', 'error' => $e->getMessage()], 500);
            } else {
                return view('errors.general', ['message' => 'Failed to delete player', 'error' => $e->getMessage()]);
            }
        }
    }
}
