<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quartier extends Model {
    protected $fillable = [
        'nom',
        'description',
    ];

    public function maisons() {
        return $this->hasMany(Maison::class);
    }
}
