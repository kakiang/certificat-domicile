<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificat extends Model {
    protected $fillable = [
        'date_demande',
        'date_delivrance',
        'habitant_id',
    ];

    protected $casts = [
        'date_demande' => 'date',
        'date_delivrance' => 'date',
    ];

    public function Habitant() {
        return $this->belongsTo(Habitant::class);
    }
}
