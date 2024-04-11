<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observaciones extends Model
{
    protected $fillable = [
        'id_inpugnacion',
        'observacion',
        // Otros campos permitidos para asignación masiva
    ];
  
    use HasFactory;
    protected $table = 'observaciones';
    protected $primaryKey = 'id_observacion';
}
