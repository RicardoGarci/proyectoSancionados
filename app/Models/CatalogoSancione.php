<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatalogoSancione extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_catalogo_sanciones';

    public function obtenerSanciones() {
        $sanciones = CatalogoSancione::where('deprecated', 0)->get(['id_catalogo_sanciones', 'nombre_sancion']);
        return ($sanciones);
    }
}
