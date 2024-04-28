<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContratResource;
use App\Models\Contrat;
use Illuminate\Http\Request;

class ContratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contrats = Contrat::all();
        return ContratResource::collection($contrats);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        $contrat = Contrat::create($request->all());

        if ($request->has('guichets')) {
            $contrat->guichets()->attach($request->input('guichets'));
        }

        return new ContratResource($contrat);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contrat  $contrat
     * @return \Illuminate\Http\Response
     */
    public function show(Contrat $contrat)
    {
        return $contrat;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contrat  $contrat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contrat $contrat)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        $contrat->update($request->only('nom'));

        if ($request->has('guichets')) {
            $contrat->guichets()->sync($request->input('guichets'));
        }

        return $contrat->fresh();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contrat  $contrat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contrat $contrat)
    {
        $contrat->guichets()->detach();
        $contrat->delete();
        return response()->json(['message' => 'Contrat deleted successfully']);
    }
}
