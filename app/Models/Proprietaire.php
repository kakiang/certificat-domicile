<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proprietaire extends Model {
    protected $fillable = [
        'nom',
        'prenom',
        'telephone',
        'date_naissance',
        'lieu_naissance',
    ];

    protected $casts = [
        'date_naissance' => 'date',
    ];

    public function maisons() {
        return $this->hasMany(Maison::class);
    }
}
