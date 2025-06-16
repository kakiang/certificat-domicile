<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proprietaire extends Model {

    public function getFullNameAttribute(){
        return "{$this->prenom} {$this->nom}";
    }
    
    protected $fillable = [
        'nom',
        'prenom',
        'telephone',
        'date_naissance',
        'lieu_naissance',
        'user_id',
    ];

    protected $casts = [
        'date_naissance' => 'date',
    ];

    public function maisons() {
        return $this->hasMany(Maison::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
