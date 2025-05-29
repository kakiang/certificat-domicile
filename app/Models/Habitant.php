<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Habitant extends Model {

    protected $fillable = [
        'nom',
        'prenom',
        'telephone',
        'date_naissance',
        'lieu_naissance',
        'maison_id',
    ];

    protected $casts = [
        'date_naissance' => 'date',
    ];

    public function maison() {
        return $this->belongsTo(Maison::class);
    }

    public function certificats() {
        $this->hasMany(Certificat::class);
    }
}
