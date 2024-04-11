<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sancionados extends Model
{
    protected $fillable = [
        'numero_expediente',
        'cargo_servidor_publico',
        'monto',
        'duracion_resolucion',
        'fecha_resolucion',
        'fecha_inicio',
        'fecha_termino',
        'id_catalogo_autoridades',
        'id_catalogo_sancionados',
        'id_catalogo_dependencia',
        'observaciones',

    ];

    use HasFactory;
    protected $primaryKey = 'id_sancionado';

    public function scopeLoadSancionadoPDF($query, $id)
    {
        return $query->from('sancionados as s')
        ->select(
            's.id_sancionado',
            'i.id_inpugnacion',
            'o.id_observacion',
            'ps.nombre_completo',
            'ps.apellidos',
            'ps.curp',
            DB::raw('s.numero_expediente as numero_expedienteSancionado'),
            DB::raw('s.fecha_resolucion as fechaResolucionSancionado'),
            DB::raw('s.fecha_inicio'),
            DB::raw('s.fecha_termino'),
            DB::raw('DATE(s.created_at) as fechaRegistro'),
            's.cargo_servidor_publico',
            's.duracion_resolucion',
            's.monto',
            'ca.nombre_autoridad',
            'cs.nombre_sancion',
            'cd.nombre_dependencia',
            'cd.nomenclatura',
            DB::raw('i.fecha_resolucion as fecha_resolucion_impugnacion'),
            DB::raw('i.numero_expediente as numero_expediente_impugnacion'),
            DB::raw('DATE(o.created_at) as fecha_creacionObservacion'),
            'o.observacion'
        )
        ->join('personas_sancionadas as ps', 'ps.id_persona_sancionada', '=', 's.id_persona_sancionada')
        ->join('catalogo_autoridades as ca', 'ca.id_catalogo_autoridades', '=', 's.id_catalogo_autoridades')
        ->join('catalogo_sanciones as cs', 'cs.id_catalogo_sanciones', '=', 's.id_catalogo_sancionados')
        ->join('catalogo_dependencia as cd', 'cd.id_catalogo_dependecia', '=', 's.id_catalogo_dependencia')
        ->join('inpugnacion as i', 'i.id_sancionado', '=', 's.id_sancionado')
        ->join('observaciones as o', 'o.id_inpugnacion', '=', 'i.id_inpugnacion')
        ->where('o.id_observacion', $id)
        ->get();
            
    }

    public function scopeLoadReport($query)
    {
        return $query->from('sancionados as s')
        ->select('ps.id_persona_sancionada',
                    'ps.nombre_completo',
                    'ps.apellidos',
                    'ps.curp',
                    's.id_catalogo_dependencia',
                    'cd.nombre_dependencia',
                    's.cargo_servidor_publico',
                    's.id_sancionado',
                    's.numero_expediente',
                    's.monto',
                    's.duracion_resolucion',
                    DB::raw('s.fecha_resolucion'),
                    DB::raw('s.fecha_inicio'),
                    DB::raw('s.fecha_termino'),
                    's.observaciones',
                    's.id_catalogo_autoridades',
                    'ca.nombre_autoridad',
                    's.id_catalogo_sancionados',
                    'cs.nombre_sancion',
                    DB::raw('DATE(s.created_at) as fechaRegistro'),
                )
        ->join('personas_sancionadas as ps', 'ps.id_persona_sancionada', '=', 's.id_persona_sancionada')
        ->join('catalogo_autoridades as ca', 'ca.id_catalogo_autoridades', '=', 's.id_catalogo_autoridades')
        ->join('catalogo_sanciones as cs', 'cs.id_catalogo_sanciones', '=', 's.id_catalogo_sancionados')
        ->join('catalogo_dependencia as cd', 'cd.id_catalogo_dependecia', '=', 's.id_catalogo_dependencia');
            
    }
}
