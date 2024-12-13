<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'causer_id',
        'latitude',
        'longitude',
        'description',
        'has_carcaca_animais',
        'has_agua_parada',
        'has_lixo_organico',
        'has_produtos_quimicos',
        'has_vidros',
        'has_materias_reciclaveis',
        'has_residuos_construcao',
        'score',
        'checked',
        'collected',
        'collected_causer_id',
    ];
    public function causer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'causer_id');
    }
    public function collectedCauser()
    {
        return $this->belongsTo(User::class, 'collected_causer_id');
    }
}
