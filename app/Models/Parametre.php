<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parametre extends Model
{
    protected $fillable = [
        'nom_commune',
        'nom_departement',
        'nom_region',
        'nom_maire',
    ];
}
