<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Impugnacion extends Model
{
    protected $fillable = [
        'id_sancionado',
        'fecha_resolucion',
        'numero_expediente',
        'tipo',
    ];
  
    use HasFactory;
    protected $table = 'inpugnacion';
    protected $primaryKey = 'id_inpugnacion';

    
}
