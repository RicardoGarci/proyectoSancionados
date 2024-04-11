<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonasSancionadas extends Model
{
    protected $fillable = [
        'nombre_completo',
        'apellidos',
        'curp',
        'rfc',

    ];
    use HasFactory;
    protected $primaryKey = 'id_persona_sancionada';

    public function obtenerPersonasSancionadas() {
        $personas =  PersonasSancionadas::select(
            'id_persona_sancionada',
            'nombre_completo',
            'apellidos',
            'curp',
            'rfc'
        )
        ->where('deprecated', 0)
        ->groupBy('id_persona_sancionada')
        ->get();
        //$sql = $personas->toSql();
        //dd($sql);
        return ($personas);
    }

}

