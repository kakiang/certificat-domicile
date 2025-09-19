<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificatDelivre extends Model
{
    protected $fillable = [
        'certificat_id',
        'numero_certificat',
        'code_secret',
        'habitant_id',
        'habitant_nom',
        'habitant_prenom',
        'habitant_telephone',
        'habitant_date_naissance',
        'habitant_lieu_naissance',
        'habitant_maison_adresse',
        'habitant_maison_proprietaire',
        'habitant_maison_quartier_nom',
        'date_demande',
        'date_delivrance',
    ];

    protected $casts = [
        'date_demande' => 'datetime',
        'date_delivrance' => 'datetime',
    ];

    public function Certificat()
    {
        return $this->belongsTo(Certificat::class);
    }

    public function scopeForCurrentUser($query)
    {
        $user = auth()->user();
        if ($user->is_admin) {
            return $query;
        }
        if ($user->habitant) {
            return $query->where('habitant_id', $user->habitant->id);
        }
        return $query->whereRaw('1=0');
    }
}
