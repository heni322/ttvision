<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrat extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nom',
        'type_contrat_id'
    ];

    public function guichets()
    {
        return $this->belongsToMany(Guichet::class, 'contract_guichet', 'contrat_id', 'guichet_id')
            ->withPivot('nombre')
            ->withTimestamps();
    }
}
