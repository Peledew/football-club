<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Services\Contracts\IClubService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\Serializer\Serializer;

class ClubController extends Controller
{
    private IClubService $_clubService;
    private Serializer $serializer;
    public function __construct(IClubService $clubService, Serializer $serializer)
    {
        $this->_clubService = $clubService;
        $this->serializer = $serializer;
    }

    public function index(): JsonResponse|View
    {
        try {
            $clubs = $this->_clubService->getAll();

            if ($clubs->isEmpty()) {
                if (request()->expectsJson()) {
                    return response()->json(['message' => 'No clubs found'], 404);
                } else {
                    return view('clubs.index', ['clubs' => $clubs, 'message' => 'No clubs found']);
                }
            }

            if (request()->expectsJson()) {
                return response()->json($clubs);
            } else {
                return view('clubs.index', compact('clubs'));
            }
        } catch (Exception $e) {
            if (request()->expectsJson()) {
                return response()->json(['message' => 'Failed to retrieve clubs', 'error' => $e->getMessage()], 500);
            } else {
                return view('errors.general', ['message' => 'Failed to retrieve clubs', 'error' => $e->getMessage()]);
            }
        }
    }

    public function store(Request $request): JsonResponse|View
    {
        if ('json' !== $request->getContentTypeFormat()) {
            return response()->json(['message' => 'Unsupported content format'], 415);
        }

        $jsonData = $request->getContent();

        // Validate JSON
        if (empty($jsonData) || is_null(json_decode($jsonData))) {
            return response()->json(['message' => 'Invalid JSON data'], 400);
        }

        try {
            $deserializedData = $this->serializer->deserialize($jsonData, Club::class, 'json');

            if (empty($deserializedData->name) || empty($deserializedData->place_id)) {
                return response()->json(['message' => 'Invalid club data'], 400);
            }

            $club = $this->_clubService->create($deserializedData);

            return response()->json($club, 201); // Success
        } catch (Exception $e) {
            if (request()->expectsJson()) {
                return response()->json(['message' => 'Failed to create club', 'error' => $e->getMessage()], 500);
            } else {
                return view('errors.general', ['message' => 'Failed to create club', 'error' => $e->getMessage()]);
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

            $club = $this->_clubService->getById($id);

            if (!$club) {
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Club not found'], 404);
                } else {
                    return view('errors.general', ['id' => $id]);
                }
            }

            if ($request->expectsJson()) {
                return response()->json($club);
            } else {
                return view('clubs.show', compact('club'));
            }
        } catch (Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Failed to retrieve club', 'error' => $e->getMessage()], 500);
            } else {
                return view('errors.general', ['message' => 'Failed to retrieve club', 'error' => $e->getMessage()]);
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

        // Validate JSON
        if (empty($jsonData) || is_null(json_decode($jsonData))) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Invalid JSON data'], 400);
            } else {
                return view('errors.invalid_json_data');
            }
        }

        try {
            $deserializedData = $this->serializer->deserialize($jsonData, Club::class, 'json');

            if (empty($deserializedData->name) || empty($deserializedData->place_id)) {
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Invalid club data'], 400);
                } else {
                    return view('errors.invalid_club_data');
                }
            }

            $club = $this->_clubService->update($id, $deserializedData);

            if (!$club) {
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Club not found'], 404);
                } else {
                    return view('errors.club_not_found', ['id' => $id]);
                }
            }

            if ($request->expectsJson()) {
                return response()->json($club);
            } else {
                return view('clubs.show', compact('club'));
            }
        } catch (Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Failed to update club', 'error' => $e->getMessage()], 500);
            } else {
                return view('errors.general', ['message' => 'Failed to update club', 'error' => $e->getMessage()]);
            }
        }
    }

    public function destroy(Request $request, int $id): JsonResponse|View
    {
        // Validate ID (ensure it's a positive integer)
        if ($id <= 0) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Invalid ID provided'], 400);
            } else {
                return view('errors.invalid_id', ['id' => $id]);
            }
        }

        try {
            $deleted = $this->_clubService->delete($id);

            if (!$deleted) {
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Club not found'], 404);
                } else {
                    return view('errors.club_not_found', ['id' => $id]);
                }
            }

            if ($request->expectsJson()) {
                return response()->json(['message' => 'Club deleted']);
            } else {
                return view('clubs.deleted', ['id' => $id]);
            }
        } catch (Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Failed to delete club', 'error' => $e->getMessage()], 500);
            } else {
                return view('errors.general', ['message' => 'Failed to delete club', 'error' => $e->getMessage()]);
            }
        }
    }
}
