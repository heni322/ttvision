<?php

namespace App\Http\Resources;

use App\Models\Contrat;
use App\Models\Guichet;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContratGuichetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $contrat = Contrat::findOrFail($this->contrat_id);
        $guichet = Guichet::findOrFail($this->guichet_id);
        return [
            'id' => $this->id,
            'contrat' => $contrat ? new ContratResource($contrat) : null,
            'guichet' => $guichet ? new GuichetResource($guichet) : null,
            'nombre' => $this->nombre,
            'recette' => $this->recette,
        ];
    }
}
