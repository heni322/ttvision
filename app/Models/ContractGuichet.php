<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractGuichet extends Model
{
    use HasFactory;

    protected $table = 'contract_guichet';

    protected $fillable = [
        'contrat_id',
        'guichet_id',
        'nombre',
        'recette',
    ];

    // Define relationships
    public function contrat()
    {
        return $this->belongsTo(Contrat::class, 'contrat_id');
    }

    public function guichet()
    {
        return $this->belongsTo(Guichet::class, 'guichet_id');
    }
}
