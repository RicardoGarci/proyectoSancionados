<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CatalogoAutoridade;
use App\Models\CatalogoSancione;
use App\Models\CatalogoDependencia;
use App\Models\PersonasSancionadas;
use App\Models\Sancionados;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ReporteDashboardController extends Controller
{
    public function index(){

        $autoridades = app(CatalogoAutoridade::class)->obtenerAutoridades();
        $sanciones = app(CatalogoSancione::class)->obtenerSanciones();
        $dependencias = app(CatalogoDependencia::class)->obtenerDependencia();
        $reportInicial = app(Sancionados::class)->scopeLoadReport(Sancionados::query())
                        ->where('s.deprecated', 0)
                        ->get();

        return view('/dashboard', compact('autoridades','sanciones','dependencias', 'reportInicial'));

    }

    public function obtenerDatosFiltrados(Request $request)
    {
       // dd($request->all());
        $fechaResolucion = $request->input('fechaResolucion');
        $fechaRegistro = $request->input('fechaRegistro');
        $autoridad = $request->input('autoridad');
        $sancion = $request->input('sancion');
        $dependencia = $request->input('dependencia');

        $fechaResolucion = implode(' - ', array_map(function($fecha) {
            return date('Y-m-d', strtotime(str_replace('/', '-', $fecha)));
        }, explode(' - ', $fechaResolucion)));
        $fechaRegistro = implode(' - ', array_map(function($fecha) {
            return date('Y-m-d', strtotime(str_replace('/', '-', $fecha)));
        }, explode(' - ', $fechaRegistro)));

        $query = app(Sancionados::class)->scopeLoadReport(Sancionados::query());
    
        if (!empty($fechaResolucion)) {
            $fechas = explode(' - ', $fechaResolucion);
            if (count($fechas) >= 2) {
                $fechaInicio = $fechas[0];
                $fechaFin = $fechas[1];
                $query->whereBetween('s.fecha_resolucion', [$fechaInicio, $fechaFin]);
            } else {
            }
        }
        
        if (!empty($fechaRegistro)) {
            $fechas1 = explode(' - ', $fechaRegistro);
            if (count($fechas1) >= 2) {
                $fechaInicio1 = $fechas1[0];
                $fechaFin1 = $fechas1[1];
                $query->whereBetween('s.created_at', [$fechaInicio1, $fechaFin1]);
            } else {
            }
        }
        if (!empty($autoridad)) {
            $query->where('s.id_catalogo_autoridades', $autoridad);
        }
        if (!empty($sancion)) {
            $query->where('s.id_catalogo_sancionados', $sancion);
        }
        if (!empty($dependencia)) {
            $query->where('s.id_catalogo_dependencia', $dependencia);
        }
        $datosFiltrados = $query->where('s.deprecated', 0)->get();
      /*    ;$sqlQuery = $datosFiltrados->toSql();
            dd ($sqlQuery); 
 */
        return response()->json($datosFiltrados);
    }
    
}
