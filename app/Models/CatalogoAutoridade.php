<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatalogoAutoridade extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_catalogo_autoridades';
    
    public function obtenerAutoridades() {
        $autoridades = CatalogoAutoridade::where('deprecated', 0)->get(['id_catalogo_autoridades', 'nombre_autoridad']);
        return ($autoridades);
    }
}
