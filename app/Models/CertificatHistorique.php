<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificatHistorique extends Model
{
    protected $fillable = [
        'certificat_id',
        'numero_certificat',
        'habitant_nom',
        'habitant_prenom',
        'habitant_telephone',
        'habitant_date_naissance',
        'habitant_lieu_naissance',
        'maison_adresse',
        'maison_proprietaire',
        'quartier_nom',
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
}
