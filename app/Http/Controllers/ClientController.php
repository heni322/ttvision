<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContratGuichetResource;
use App\Models\ContractGuichet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($contratId)
    {

        $contractGuichets = DB::table('contract_guichet')
            ->join('contrats', 'contract_guichet.contrat_id', '=', 'contrats.id')
            ->where('contrats.type_contrat_id', $contratId)
            ->orderByDesc('contract_guichet.id')
            ->select('contract_guichet.*')
            ->get();
        return response()->json(ContratGuichetResource::collection($contractGuichets));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'contrat_id' => 'required|exists:contrats,id',
            'guichet_id' => 'required|exists:guichets,id',
            'nombre' => 'required|integer',
            'recette' => 'required|numeric',
        ]);

        $contractGuichet = ContractGuichet::create($request->all());

        return response()->json(new ContratGuichetResource($contractGuichet), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $contractGuichet = ContractGuichet::findOrFail($id);
        return response()->json(new ContratGuichetResource($contractGuichet));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'contrat_id' => 'required|exists:contrats,id',
            'guichet_id' => 'required|exists:guichets,id',
            'nombre' => 'required|integer',
            'recette' => 'required|numeric',
        ]);

        $contractGuichet = ContractGuichet::findOrFail($id);
        $contractGuichet->update($request->all());

        return response()->json(new ContratGuichetResource($contractGuichet), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $contractGuichet = ContractGuichet::findOrFail($id);
        $contractGuichet->delete();

        return response()->json(null, 204);
    }
    public function deleteByIds(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:contract_guichets,id',
        ]);

        $ids = $request->input('ids');
        ContractGuichet::whereIn('id', $ids)->delete();

        return response()->json(null, 204);
    }
}
