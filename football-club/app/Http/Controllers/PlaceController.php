<?php

namespace App\Http\Controllers;

use App\Models\Place;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    public function index()
    {
        return Place::all();
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'ptt' => 'required|integer',
        ]);

        $place = Place::create($fields);
        return $place;
    }

    //TODO: Uradi sa ID
    public function show(Place $place)
    {
        return $place;
    }

    public function update(Request $request, Place $place)
    {
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'ptt' => 'required|integer',
        ]);

        $place -> update($fields);
        return $place;
    }

    public function destroy(Place $place)
    {
        $place -> delete();

        return ['message' => 'Place was deleted'];
    }
}
