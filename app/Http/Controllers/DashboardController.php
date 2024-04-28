<?php

namespace App\Http\Controllers;

use App\Http\Resources\ContratResource;
use App\Http\Resources\SampleContratResource;
use App\Models\ContractGuichet;
use App\Models\Contrat;
use App\Models\ContratType;
use App\Models\Guichet;
use App\Models\Satisfaction;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function getContractGuichetsWithSum(Request $request): JsonResponse
    {
        $currentDate = Carbon::now()->toDateString();

        $totalSum = ContractGuichet::sum('nombre');

        $dailySum = ContractGuichet::whereDate('created_at', $currentDate)
            ->sum('nombre');

        return response()->json([
            'total' => (int) $totalSum,
            'day' => (int) $dailySum
        ], 200);
    }

    public function getContractGuichetsRecetteSum(Request $request): JsonResponse
    {
        $currentDate = Carbon::now()->toDateString();
        $lastWeekStartDate = Carbon::now()->subWeek()->startOfWeek()->toDateString();
        $lastWeekEndDate = Carbon::now()->subWeek()->endOfWeek()->toDateString();

        // Calculate sum of recettes for the current week
        $currentWeekSum = ContractGuichet::whereBetween('created_at', [$lastWeekStartDate, $currentDate])
            ->sum('recette');

        // Calculate sum of recettes for the previous week
        $lastWeekSum = ContractGuichet::whereBetween('created_at', [$lastWeekStartDate, $lastWeekEndDate])
            ->sum('recette');

        // Calculate percentage change
        $percentageChange = $lastWeekSum != 0 ? (($currentWeekSum - $lastWeekSum) / $lastWeekSum) * 100 : 0;

        return response()->json([
            'total' => (int) $currentWeekSum,
            'percentageChange' => (float) $percentageChange
        ], 200);
    }

    public function contractsByType()
    {
        // Get distinct contract types
        $contractTypes = ContratType::all();

        // Prepare data array
        $data = [];

        // Loop through each contract type
        foreach ($contractTypes as $contractType) {
            $typeId = $contractType->id;
            $typeName = $contractType->nom;

            // Prepare monthly data array for this contract type
            $monthlyData = [];
            $contratbyType = Contrat::Where('type_contrat_id', $typeId)->get();

            // Loop through each month (1 to 12)
            for ($i = 1; $i <= 12; $i++) {
                // Prepare data for this month
                $contracts = ContractGuichet::whereHas('contrat', function ($query) use ($typeId) {
                    $query->where('type_contrat_id', $typeId);
                })
                ->whereMonth('created_at', $i)
                ->get();

                // Calculate total nombre for each contract type in this month
                $totalNombre = $contracts->groupBy('contrat_id')->map(function ($contractGroup) {
                    return $contractGroup->sum('nombre');
                });
                // Prepare contract data for this month
                $contractData = $totalNombre->map(function ($total, $contractId) {
                    $contractName = Contrat::find($contractId)->nom;
                    return [
                        'nom' => $contractName,
                        'total_nombre' => $total,
                    ];
                });

                // Assign monthly data for this month
                $monthlyData[$i] = $contractData->values()->toArray(); // Convert to array of objects
            }

            // Add data for this contract type to the main data array
            $data[] = [
                'type_id' => $typeId,
                'type_name' => $typeName,
                'contarts' => $contratbyType ? SampleContratResource::collection($contratbyType) : [],
                'monthly_counts' => $monthlyData,
            ];
        }

        // Return JSON response
        return response()->json($data);
    }
    public function getRecentContracts(Request $request)
    {
        $recentContracts = ContractGuichet::orderBy('id', 'desc')
            ->limit(20)
            ->get()
            ->map(function ($contract) {
                $contratName = Contrat::findOrFail($contract->contrat_id)->nom;
                $guichetName = Guichet::findOrFail($contract->guichet_id)->nom;
                return [
                    'id' => $contract->id,
                    'contrat_name' => $contratName,
                    'guichet_name' => $guichetName,
                    'nombre' => $contract->nombre,
                    'recette' => $contract->recette,
                    'created_at' => Carbon::parse($contract->created_at)->format('d/m/Y'),
                ];
            });

    return response()->json($recentContracts);
    }

    public function getBestContracts(Request $request)
    {
      // Query to get the total sum of 'nombre'
      $totalNombre = ContractGuichet::sum('nombre');

      // Query to get the best selling contracts with their percentage
      $bestSellingContracts = ContractGuichet::select('contrat_id')
          ->selectRaw('SUM(nombre) as total_nombre')
          ->groupBy('contrat_id')
          ->orderByDesc('total_nombre')
          ->limit(5) // Adjust the limit as needed
          ->get()
          ->map(function ($contract) use ($totalNombre) {
              $percentage = ($contract->total_nombre / $totalNombre) * 100;
              $contratName = Contrat::findOrFail($contract->contrat_id)->nom;
              return [
                  'contrat_name' => $contratName,
                //   'total_nombre' => $contract->total_nombre,
                  'percentage' => round($percentage, 2) // Round to 2 decimal places
              ];
          });

      return response()->json($bestSellingContracts);
    }

    public function getSatisfactions(Request $request)
    {
        // Find the Satisfaction instance by ID
        $satisfaction = Satisfaction::first();
        if (!$satisfaction){
            return response()->json("Not Found", 400);
        }
        // Return a response indicating success
        return response()->json($satisfaction->nombre, 200);
    }

    public function updateSatisfactions(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required',
        ]);
        $satisfaction = Satisfaction::first();
        $satisfaction->update($validatedData);
        return response()->json(['message' => 'Satisfaction updated successfully'], 200);
    }

}
