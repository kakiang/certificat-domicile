<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Habitant extends Model
{
    public function getFullNameAttribute()
    {
        return "{$this->prenom} {$this->nom}";
    }

    protected $fillable = [
        'nom',
        'prenom',
        'telephone',
        'date_naissance',
        'lieu_naissance',
        'maison_id',
        'user_id',
    ];

    protected $casts = [
        'date_naissance' => 'date',
    ];

    public function maison()
    {
        return $this->belongsTo(Maison::class);
    }

    public function certificats()
    {
        $this->hasMany(Certificat::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeForCurrentUser($query)
    {
        $user = auth()->user();
        if ($user->is_admin) {
            return $query;
        }
        if ($user->habitant) {
            return $query->where('user_id', $user->id);
        }
        return $query->whereRaw('1=0');
    }
}
