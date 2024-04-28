<?php

namespace App\Http\Controllers;

use App\Models\Guichet;
use Illuminate\Http\Request;

class GuichetController extends Controller
{
    public function index()
    {
        $guichets = Guichet::all();
        return response()->json($guichets);
    }

    public function show($id)
    {
        $guichet = Guichet::findOrFail($id);
        return response()->json($guichet);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string',
        ]);

        $guichet = Guichet::create($request->all());
        return response()->json($guichet, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string',
        ]);

        $guichet = Guichet::findOrFail($id);
        $guichet->update($request->all());
        return response()->json($guichet, 200);
    }

    public function destroy($id)
    {
        $guichet = Guichet::findOrFail($id);
        $guichet->delete();
        return response()->json(null, 204);
    }
}
