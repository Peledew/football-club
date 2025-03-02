<?php

namespace App\Http\Controllers;

use App\DTOs\ClubDTO;
use App\Services\Contracts\IClubService;
use Illuminate\Http\Request;

class ClubController extends Controller
{
    private IClubService $_clubService;

    public function __construct(IClubService $clubService)
    {
        $this->_clubService = $clubService;
    }

    public function index()
    {
        return response()->json($this->_clubService->getAll());
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'place_id' => 'required|integer|exists:places,id',
        ]);

        $dto = ClubDTO::fromArray($fields);
        return response()->json($this->_clubService->create($dto), 201);
    }

    public function show(int $id)
    {
        $club = $this->_clubService->getById($id);
        if (!$club) {
            return response()->json(['message' => 'Club not found'], 404);
        }
        return response()->json($club);
    }

    public function update(Request $request, int $id)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'place_id' => 'required|integer|exists:places,id',
        ]);

        $dto = ClubDTO::fromArray($fields);
        $club = $this->_clubService->update($id, $dto);

        if (!$club) {
            return response()->json(['message' => 'Club not found'], 404);
        }

        return response()->json($club);
    }

    public function destroy(int $id)
    {
        $deleted = $this->_clubService->delete($id);
        if (!$deleted) {
            return response()->json(['message' => 'Club not found'], 404);
        }

        return response()->json(['message' => 'Club deleted']);
    }
}
