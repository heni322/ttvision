<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContratTypeResource;
use App\Models\Contrat;
use App\Models\ContratType;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allContratTypes = ContratType::all();
        return ContratTypeResource::collection($allContratTypes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getContractsByType($type)
    {
        $contracts = Contrat::where('type_contrat_id', $type)->get();
        return response()->json($contracts);
    }
}
