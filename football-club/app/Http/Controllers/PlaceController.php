<?php

namespace App\Http\Controllers;

use App\DTOs\PlaceDTO;
use App\Services\Contracts\IPlaceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    private IPlaceService $_placeService;
    public function __construct(IPlaceService $placeService)
    {
        $this->_placeService = $placeService;
    }

    public function index():JsonResponse
    {
        return response()->json($this->_placeService->getAll());
    }

    public function store(Request $request): JsonResponse
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'ptt' => 'required|integer',
        ]);

        $placeDTO = PlaceDTO::fromArray($fields);
        return response()->json($this->_placeService->create($placeDTO), 201);
    }

    public function show(int $id): JsonResponse
    {
        $place = $this->_placeService->getById($id);
        if (!$place) {
            return response()->json(['message' => 'Place not found'], 404);
        }

        return response()->json($place);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'ptt' => 'required|integer',
        ]);

        $placeDTO = PlaceDTO::fromArray($fields);
        $place = $this->_placeService->update($id, $placeDTO);

        if (!$place) {
            return response()->json(['message' => 'Place not found'], 404);
        }

        return response()->json($place);
    }

    public function destroy(int $id): JsonResponse
    {
        if (!is_numeric($id) || $id <= 0) {
            return response()->json(['message' => 'Invalid ID provided'], 400);
        }

        $deleted = $this->_placeService->delete($id);

        if (!$deleted) {
            return response()->json(['message' => 'Place not found'], 404);
        }

        return response()->json(['message' => 'Place was deleted']);
    }
}

