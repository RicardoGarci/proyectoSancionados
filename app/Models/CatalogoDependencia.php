<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatalogoDependencia extends Model
{
    use HasFactory;
    protected $table = 'catalogo_dependencia';
    protected $primaryKey = 'id_catalogo_dependecia';
    
    public function obtenerDependencia() {
        $dependencias = CatalogoDependencia::where('deprecated', 0)->get(['id_catalogo_dependecia', 'nombre_dependencia']);
        return ($dependencias);
    }
}
