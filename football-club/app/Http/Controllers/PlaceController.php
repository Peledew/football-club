<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Services\Contracts\IPlaceService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\Serializer\Serializer;

class PlaceController extends Controller
{
    private IPlaceService $_placeService;
    private Serializer $serializer;
    public function __construct(IPlaceService $placeService, Serializer $serializer)
    {
        $this->_placeService = $placeService;
        $this->serializer = $serializer;
    }

    public function index(): JsonResponse|View
    {
        try {
            $places = $this->_placeService->getAll();

            if ($places->isEmpty()) {
                if (request()->expectsJson()) {
                    return response()->json(['message' => 'No places found'], 404);
                } else {
                    return view('places.index', ['places' => $places, 'message' => 'No places found']);
                }
            }

            if (request()->expectsJson()) {
                return response()->json($places);
            } else {
                return view('places.index', compact('places'));
            }
        } catch (Exception $e) {
            if (request()->expectsJson()) {
                return response()->json(['message' => 'Failed to retrieve places', 'error' => $e->getMessage()], 500);
            } else {
                return view('errors.general', ['message' => 'Failed to retrieve places', 'error' => $e->getMessage()]);
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
            $deserializedData = $this->serializer->deserialize($jsonData, Place::class, 'json');

            $place = $this->_placeService->create($deserializedData);

            return response()->json($place, 201); // Success
        } catch (Exception $e) {
            if (request()->expectsJson()) {
                return response()->json(['message' => 'Failed to create place', 'error' => $e->getMessage()], 500);
            } else {
                return view('errors.general', ['message' => 'Failed to create place', 'error' => $e->getMessage()]);
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

            $place = $this->_placeService->getById($id);

            if (!$place) {
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Place not found'], 404);
                } else {
                    return view('errors.general', ['id' => $id]);
                }
            }

            if (request()->expectsJson()) {
                return response()->json($place);
            } else {
                return view('places.show', compact('place'));
            }

        } catch (Exception $e) {
            if (request()->expectsJson()) {
                return response()->json(['message' => 'Failed to retrieve place', 'error' => $e->getMessage()], 500);
            } else {
                return view('errors.general', ['message' => 'Failed to retrieve place', 'error' => $e->getMessage()]);
            }
        }
    }

    public function update(Request $request, int $id): JsonResponse|View
    {
        if ('json' !== $request->getContentTypeFormat()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unsupported content format'], 415);
            } else {
                return view('errors.general', ['message' => 'Unsupported content format']);
            }
        }

        $jsonData = $request->getContent();

        // Validate JSON
        if (empty($jsonData) || is_null(json_decode($jsonData))) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Invalid JSON data'], 400);
            } else {
                return view('errors.general', ['message' => 'Invalid JSON data']);
            }
        }

        try {
            $deserializedData = $this->serializer->deserialize($jsonData, Place::class, 'json');

            $place = $this->_placeService->update($id, $deserializedData);

            if (!$place) {
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Place not found'], 404);
                } else {
                    return view('errors.general', ['id' => $id]);
                }
            }

            if ($request->expectsJson()) {
                return response()->json($place);
            } else {
                return view('places.show', compact('place'));
            }
        } catch (Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Failed to update place', 'error' => $e->getMessage()], 500);
            } else {
                return view('errors.general', ['message' => 'Failed to update place', 'error' => $e->getMessage()]);
            }
        }
    }

    public function destroy(Request $request, int $id): JsonResponse|View|RedirectResponse
    {
        // Validate ID (ensure it's a positive integer)
        if ($id <= 0) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Invalid ID provided'], 400);
            } else {
                return view('errors.general', ['message' => 'Invalid ID provided']);
            }
        }

        try {
            $deleted = $this->_placeService->delete($id);

            if (!$deleted) {
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Place not found'], 404);
                } else {
                    return view('errors.general', ['message' => 'Failed to find place']);
                }
            }

            if ($request->expectsJson()) {
                return response()->json(['message' => 'Place deleted']);
            } else {
                return redirect()->route('places.index');
            }
        } catch (Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Failed to delete place', 'error' => $e->getMessage()], 500);
            } else {
                return view('errors.general', ['message' => 'Failed to delete place', 'error' => $e->getMessage()]);
            }
        }
    }
}

