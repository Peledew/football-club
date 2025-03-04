<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Services\Contracts\ICompetitionService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\Serializer\Serializer;

class CompetitionController extends Controller
{
    private ICompetitionService $_competitionService;
    private Serializer $serializer;

    public function __construct(ICompetitionService $competitionService, Serializer $serializer)
    {
        $this->_competitionService = $competitionService;
        $this->serializer = $serializer;
    }

    public function index(): JsonResponse|View
    {
        try {
            $competitions = $this->_competitionService->getAll();

            if ($competitions->isEmpty()) {
                if (request()->expectsJson()) {
                    return response()->json(['message' => 'No competitions found'], 404);
                } else {
                    return view('errors.general', ['message' => 'No competitions found']);
                }
            }

            if (request()->expectsJson()) {
                return response()->json($competitions);
            } else {
                return view('competitions.index', compact('competitions'));
            }
        } catch (Exception $e) {
            if (request()->expectsJson()) {
                return response()->json(['message' => 'Failed to retrieve competitions', 'error' => $e->getMessage()], 500);
            } else {
                return view('errors.general', ['message' => 'Failed to retrieve competitions', 'error' => $e->getMessage()]);
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
            $deserializedData = $this->serializer->deserialize($jsonData, Competition::class, 'json');

            $competition = $this->_competitionService->create($deserializedData);

            if ($request->expectsJson()) {
                return JsonResponse::fromJsonString($competition);
            } else {
                return view('competitions.show', compact('competition'));
            }

        } catch (Exception $e) {
            if (request()->expectsJson()) {
                return response()->json(['message' => 'Failed to create competition', 'error' => $e->getMessage()], 500);
            } else {
                return view('errors.general', ['message' => 'Failed to create competition', 'error' => $e->getMessage()]);
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

            $competition = $this->_competitionService->getById($id);

            if (!$competition) {
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Competition not found'], 404);
                } else {
                    return view('errors.general', ['id' => $id]);
                }
            }

            if ($request->expectsJson()) {
                return JsonResponse::fromJsonString($competition);
            } else {
                return view('competitions.show', compact('competition'));
            }

        } catch (Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Failed to retrieve competition', 'error' => $e->getMessage()], 500);
            } else {
                return view('errors.general', ['message' => 'Failed to retrieve competition', 'error' => $e->getMessage()]);
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
            $deserializedData = $this->serializer->deserialize($jsonData, Competition::class, 'json');

            $competition = $this->_competitionService->update($id, $deserializedData);

            if (!$competition) {
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Competition not found'], 404);
                } else {
                    return view('errors.general', ['id' => $id]);
                }
            }

            if ($request->expectsJson()) {
                return response()->json($competition);
            } else {
                return view('competitions.show', compact('competition'));
            }
        } catch (Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Failed to update competition', 'error' => $e->getMessage()], 500);
            } else {
                return view('errors.general', ['message' => 'Failed to update competition', 'error' => $e->getMessage()]);
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
            $deleted = $this->_competitionService->delete($id);

            if (!$deleted) {
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'Competition not found'], 404);
                } else {
                    return view('errors.general', ['message' => 'Failed to find competition']);
                }
            }

            if ($request->expectsJson()) {
                return response()->json(['message' => 'Competition deleted']);
            } else {
                return redirect()->route('competitions.index');
            }
        } catch (Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Failed to delete competition', 'error' => $e->getMessage()], 500);
            } else {
                return view('errors.general', ['message' => 'Failed to delete competition', 'error' => $e->getMessage()]);
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
            $competition = Competition::findOrFail($id);

            if ($request->expectsJson()) {
                return response()->json($competition);
            } else {
                return view('competitions.edit', compact('competition'));
            }
        } catch (Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Failed to retrieve competition for editing', 'error' => $e->getMessage()], 500);
            } else {
                return view('errors.general', ['message' => 'Failed to retrieve competition for editing', 'error' => $e->getMessage()]);
            }
        }
    }

}

