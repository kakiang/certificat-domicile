<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maison extends Model {
    protected $fillable = [
        'numero',
        'description',
        'proprietaire_id',
        'quartier_id',
    ];

    public function proprietaire() {
        return $this->belongsTo(Proprietaire::class);
    }

    public function quartier() {
        return $this->belongsTo(Quartier::class);
    }

    public function habitants(){
        return $this->hasMany(Habitant::class);
    }
}
