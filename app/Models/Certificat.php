<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificat extends Model
{
    protected $fillable = [
        'numero_certificat',
        'date_demande',
        'date_delivrance',
        'habitant_id',
        'piece_identite',
        'piece_identite_file_path',
        'piece_identite_slug',
        'justificatif_domicile',
        'justificatif_domicile_file_path',
        'justificatif_domicile_slug',
        'is_paid',
        'status',
        'observation',
    ];

    protected $casts = [
        'date_demande' => 'datetime',
        'date_delivrance' => 'datetime',
    ];

    public function Habitant()
    {
        return $this->belongsTo(Habitant::class);
    }

    public function CertificatDelivre()
    {
        return $this->hasOne(CertificatDelivre::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

     public function markAsPaid()
    {
        $this->update([
            'is_paid' => true,
        ]);
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
