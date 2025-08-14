<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maison extends Model {

    public function getFullNameAttribute(){
        return "{$this->numero} {$this->proprietaire->full_name}";
    }

    protected $fillable = [
        'numero',
        'adresse',
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
