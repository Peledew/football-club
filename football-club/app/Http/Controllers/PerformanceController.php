<?php

namespace App\Http\Controllers;

use App\Models\Performance;
use App\Services\Contracts\IPerformanceService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\Serializer\Serializer;

class PerformanceController extends Controller
{
    private IPerformanceService $_performanceService;
    private Serializer $serializer;

    public function __construct(IPerformanceService $performanceService, Serializer $serializer)
    {
        $this->_performanceService = $performanceService;
        $this->serializer = $serializer;
    }

    public function index(): JsonResponse|View
    {
        try {
            $performances = $this->_performanceService->getAll();

            if ($performances->isEmpty()) {
                if (request()->expectsJson()) {
                    return response()->json(['message' => 'No performances found'], 404);
                } else {
                    return view('errors.general', ['message' => 'No performances found']);
                }
            }

            if (request()->expectsJson()) {
                return response()->json($performances);
            } else {
                return view('performances.index', compact('performances'));
            }
        } catch (Exception $e) {
            if (request()->expectsJson()) {
                return response()->json(['message' => 'Failed to retrieve performances', 'error' => $e->getMessage()], 500);
            } else {
                return view('errors.general', ['message' => 'Failed to retrieve performances', 'error' => $e->getMessage()]);
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
            $deserializedData = $this->serializer->deserialize($jsonData, Performance::class, 'json');

            $performance = $this->_performanceService->create($deserializedData);

            if ($request->expectsJson()) {
                return JsonResponse::fromJsonString($performance);
            } else {
                return view('performances.show', compact('performance'));
            }

        } catch (Exception $e) {
            if (request()->expectsJson()) {
                return response()->json(['message' => 'Failed to create performance', 'error' => $e->getMessage()], 500);
            } else {
                return view('errors.general', ['message' => 'Failed to create performance', 'error' => $e->getMessage()]);
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

            $performance = $this->_performanceService->getById($id);

            if (!$performance) {
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Performance not found'], 404);
                } else {
                    return view('errors.general', ['id' => $id]);
                }
            }

            if ($request->expectsJson()) {
                return JsonResponse::fromJsonString($performance);
            } else {
                return view('performances.show', compact('performance'));
            }

        } catch (Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Failed to retrieve performance', 'error' => $e->getMessage()], 500);
            } else {
                return view('errors.general', ['message' => 'Failed to retrieve performance', 'error' => $e->getMessage()]);
            }
        }
    }

    public function update(Request $request, int $id): JsonResponse|View|RedirectResponse
    {
        if ('json' !== $request->getContentTypeFormat()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unsupported content format'], 415);
            } else {
                return view('errors.general', ['message' => 'Unsupported content format']);
            }
        }

        $jsonData = $request->getContent();

        if (empty($jsonData) || is_null(json_decode($jsonData))) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Invalid JSON data'], 400);
            } else {
                return view('errors.general', ['message' => 'Invalid JSON data']);
            }
        }

        try {
            $deserializedData = $this->serializer->deserialize($jsonData, Performance::class, 'json');

            $performance = $this->_performanceService->update($id, $deserializedData);

            if (!$performance) {
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Performance not found'], 404);
                } else {
                    return view('errors.general', ['id' => $id]);
                }
            }

            if ($request->expectsJson()) {
                return response()->json($performance);
            } else {
                return view('performances.show', compact('performance'));
            }
        } catch (Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Failed to update performance', 'error' => $e->getMessage()], 500);
            } else {
                return view('errors.general', ['message' => 'Failed to update performance', 'error' => $e->getMessage()]);
            }
        }
    }

    public function destroy(Request $request, int $id): JsonResponse|View|RedirectResponse
    {
        if ($id <= 0) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Invalid ID provided'], 400);
            } else {
                return view('errors.general', ['message' => 'Invalid ID provided']);
            }
        }

        try {
            $deleted = $this->_performanceService->delete($id);

            if (!$deleted) {
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Performance not found'], 404);
                } else {
                    return view('errors.general', ['message' => 'Failed to find performance']);
                }
            }

            if ($request->expectsJson()) {
                return response()->json(['message' => 'Performance deleted']);
            } else {
                return redirect()->route('performances.index');
            }
        } catch (Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Failed to delete performance', 'error' => $e->getMessage()], 500);
            } else {
                return view('errors.general', ['message' => 'Failed to delete performance', 'error' => $e->getMessage()]);
            }
        }
    }


    public function edit(Request $request, int $id): JsonResponse|View
    {
        if ($id <= 0) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Invalid ID provided'], 400);
            } else {
                return view('errors.general', ['message' => 'Invalid ID provided']);
            }
        }

        try {
            $performance = Performance::findOrFail($id);

            if ($request->expectsJson()) {
                return response()->json($performance);
            } else {
                return view('performances.edit', compact('performance'));
            }
        } catch (Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Failed to retrieve performance for editing', 'error' => $e->getMessage()], 500);
            } else {
                return view('errors.general', ['message' => 'Failed to retrieve performance for editing', 'error' => $e->getMessage()]);
            }
        }
    }

}
