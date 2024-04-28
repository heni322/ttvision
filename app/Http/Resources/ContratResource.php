<?php

namespace App\Http\Resources;

use App\Models\ContratType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContratResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $contratType = ContratType::findOrFail($this->type_contrat_id);
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'type_contrat' => new ContratTypeResource($contratType),
        ];
    }
}
