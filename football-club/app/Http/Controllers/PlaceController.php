<?php

namespace App\Http\Controllers;

use App\DTOs\PlaceDTO;
use App\Models\Place;
use App\Services\Contracts\IPlaceService;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    private IPlaceService $_placeService;
    public function __construct(IPlaceService $placeService)
    {
        $this->_placeService = $placeService;
    }

    public function index()
    {
        return response()->json($this->_placeService->getAllPlaces());
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'ptt' => 'required|integer',
        ]);

        $placeDTO = PlaceDTO::fromArray($fields);
        return response()->json($this->_placeService->createPlace($placeDTO), 201);
    }

    public function show(int $id)
    {
        $place = $this->_placeService->getPlaceById($id);
        if (!$place) {
            return response()->json(['message' => 'Place not found'], 404);
        }

        return response()->json($place);
    }

    public function update(Request $request, int $id)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'ptt' => 'required|integer',
        ]);

        $placeDTO = PlaceDTO::fromArray($fields);
        $place = $this->_placeService->updatePlace($id, $placeDTO);

        if (!$place) {
            return response()->json(['message' => 'Place not found'], 404);
        }

        return response()->json($place);
    }

    public function destroy(int $id)
    {
        $deleted = $this->_placeService->deletePlace($id);

        if (!$deleted) {
            return response()->json(['message' => 'Place not found'], 404);
        }

        return response()->json(['message' => 'Place was deleted']);
    }
}
