<?php

namespace App\Http\Controllers;
use App\Models\Sancionados;
use App\Models\Impugnacion;
use App\Models\Observaciones;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\Response;

class ImpugnacionController extends Controller
{

    function formatearFecha($fecha){
        if (empty($fecha)) {
            return ''; 
        }
        $meses = [
            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
        ];
        $fechaCarbon = Carbon::parse($fecha);
        $mes = $meses[$fechaCarbon->format('n') - 1];
        return $fechaCarbon->format('d') . ' de ' . $mes . ' de ' . $fechaCarbon->format('Y');
    }

    public function loadPDFimpugnar($data){

        $datos = Sancionados::scopeLoadSancionadoPDF(Sancionados::query(),$data)->first();

        $fechaResolucion = $this->formatearFecha($datos->fechaResolucionSancionado);
        $fechaInicio = $this->formatearFecha($datos->fecha_inicio);
        $fechaTermino = $this->formatearFecha($datos->fecha_termino);
        $fechaRegistro = $this->formatearFecha($datos->fechaRegistro);
        $fechaActual = $this->formatearFecha(Carbon::now());
        $tbl = '
            <div align="CENTER">
            <strong><font size="20" style="color:#9D2449;">Reporte extraído del sistema que acredite la existencia de impugnaciones</font>
            </strong><br>
            </div>
            <div  style="text-align: justify;" align="left">
            <font>Identificador Del Sancionado:</font> <font style="color:#616161;">' .$datos->id_sancionado .'</font><br>
            <font>Nombre:</font> <font style="color:#616161;">' .$datos->nombre_completo .' '. $datos->apellidos .'</font><br>
            <font>Sanción Impuesta:</font> <font style="color:#616161;">' .$datos->nombre_sancion.'</font><br>
            <font>Nº De Expediente:</font> <font style="color:#616161;">' .$datos->numero_expedienteSancionado.'</font><br>
            <font>Autoridad Sancionadora:</font> <font style="color:#616161;">' .$datos->nombre_autoridad.'</font><br>
            <font>Fecha De Resolución:</font> <font style="color:#616161;">' .$fechaResolucion.'</font><br>
            <font>Duración:</font> <font style="color:#616161;">'.$datos->duracion_resolucion.'</font><br>
            <font>Monto:</font> <font style="color:#616161;">$' .$datos->monto.'</font><br>
            <font>Fecha De Inicio:</font> <font style="color:#616161;">' .$fechaInicio.'</font><br>
            <font>Fecha De Término:</font> <font style="color:#616161;">' .$fechaTermino.'</font><br>
            <font>Fecha De Registro:</font> <font style="color:#616161;">' .$fechaRegistro.'</font><br>
            <font>Cargo Del Servidor Público Sancionado:</font> <font style="color:#616161;">' .$datos->cargo_servidor_publico.'</font><br>
            <font>Nombre Del Ente Público:</font> <font style="color:#616161;">' .$datos->nombre_dependencia.' (' .$datos->nomenclatura.')</font><br>
            </div>

            <div style="text-align: justify;"> 
            <font>Falta Por La Cual Fue Sancionado:</font><br>
            <font style="color:#616161;">'.$datos->observacion .'</font><br>
            </div>

            <table>
            <tr>
                <td><font style="color:#616161;">Tlalixtac de Cabrera, ' .
                        $fechaActual .
                        '</font></td>
                <td align="right"><strong><font style="color:#B38E5D;">www.oaxaca.gob.mx/</font><font style="color:#9D2449;">honestidad</font></strong></td>
            </tr>
            </table>
        ';

        PDF::setHeaderCallback(function ($pdf) {
        // Agregar la imagen a la página
            $pdf->Image('imagenes/grecas.jpg', 185, 0, 50, null, '', '', '', false, 300, '', false, false, 0);
            $pdf->Image('imagenes/grecas.jpg', 185, 240, 50, null, '', '', '', false, 300, '', false, false, 0);
            $pdf->Image('imagenes/COLOR.PNG', 15, 10, 170, 25, '', '', '', false, 300, '', false, false, 0);
            //$pdf->Image('imagenes/GRIS.PNG', 15, 10, 170, 25, '', '', '', false, 300, '', false, false, 0);   
            $pdf->Image('imagenes/abajo.jpg', -8, 270, 0, 8, '', '', '', false, 300, '', false, false, 0);
        });

        PDF::SetAuthor('PRUEBA SANCIONADOS');
        PDF::SetTitle('Constancia de SANCIONADOS');
        PDF::SetSubject('SANCIONADOS');
        PDF::SetMargins(20, 40, 32);
        PDF::SetFontSubsetting(false);
        PDF::SetAutoPageBreak(true, 20);
        PDF::AddPage('P', 'LETTER');
        // PDF::SetFont('Montserrat-Regular', '', 14);
        PDF::SetFont('times', '', '13');
        PDF::writeHTML($tbl, true, false, true, false, '');
        //PDF::AddPage();
        PDF::Output('Constancia de SANCIONADO.pdf', 'I');
    }

    public function loadDocumentosImpugnacion($id_sancionado){
        try {
            $observaciones = Sancionados::from('sancionados as s')
                ->select(
                    's.id_sancionado',
                    'i.id_inpugnacion',
                    'i.fecha_resolucion',
                    'i.numero_expediente',
                    DB::raw('DATE(o.created_at) as fecha_creacion'),
                    'o.id_observacion',
                    'o.observacion'
                )
                ->join('inpugnacion as i', 'i.id_sancionado', '=', 's.id_sancionado')
                ->join('observaciones as o', 'o.id_inpugnacion', '=', 'i.id_inpugnacion')
                ->where('s.id_sancionado', $id_sancionado)
                ->get(); 
                foreach ($observaciones as $observacion) {
                    $observacion->fecha_resolucion = Carbon::parse($observacion->fecha_resolucion)->locale('es')->isoFormat('LL');
                    $observacion->fecha_creacion = Carbon::parse($observacion->fecha_creacion)->locale('es')->isoFormat('LL');
                }
                return response()->json($observaciones); // Retornamos los datos, no la vista
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
      

    public function loadImpugnar($id) {
        try {
            $impugnacion = Impugnacion::where('id_sancionado', $id)->first();
            return response()->json($impugnacion);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    } 

    public function activarImpugnar($id) {
        try {    
            $sancionado = Sancionados::find($id);
                // Actualizar el estado del sancionado a 0 (activo)
                $sancionado->deprecated = 0;
                $sancionado->save();
                
                session()->flash('mensaje', 'La sanción fue activada correctamente');
                return back()->with('status', 200);
        } catch (\Exception $e) {
            session()->flash('mensaje', 'No se pudo activar la sanción.Contacte al  Administrador');
            return back()->with('status', 500);
        }
    } 
    
    public function impugnar(Request $request){
        $data = $request->all();
        $impugando= $request->input('id_impugnacion');
         DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'tipoInpugnacion' => ['required'],
                'fechaResolucion' => ['required'],
                'numeroExpediente' => ['required'],
                'observacionesInpugnacion' => ['required']
            
            ]);
            
            if ($validator->fails()) {
                session()->flash('mensaje', 'Los campos no deben venir vacios.');
                return back()->with('status', 400);
            }
            

            if ($impugando === null) {
                // Actualizar la tabla sancionados en específico deprecated = 1
                Sancionados::where('id_sancionado', $request->input('id_sancionado'))
                    ->update(['deprecated' => 1]);
    
                // Creación del nuevo registro en la tabla Impugnar
                $inpugnacion = Impugnacion::create([
                    'id_sancionado' => $request->input('id_sancionado'),
                    'tipo' => $request->input('tipoInpugnacion'),
                    'fecha_resolucion' => date("Y-m-d", strtotime(str_replace('/', '-', $request->input('fechaResolucion')))),
                    'numero_expediente' => $request->input('numeroExpediente')
                ]);
               
                $idInpugnacion = $inpugnacion->id_inpugnacion; 
    
                Observaciones::create([
                    'id_inpugnacion' => $idInpugnacion,
                    'observacion' => $request->input('observacionesInpugnacion')
                ]);
            } else {

                // Actualizar la tabla sancionados en específico deprecated = 1
                Sancionados::where('id_sancionado', $request->input('id_sancionado')) ->update(['deprecated' => 1]);
                $idInpugnacion =  $impugando; 
    
                Observaciones::create([
                    'id_inpugnacion' => $idInpugnacion,
                    'observacion' => $request->input('observacionesInpugnacion')
                ]);
               
            }
            //$this->loadPDFimpugnar($request->input('id_sancionado'),$data);
            //$this->loadPDFimpugnar($data);
            DB::commit();
            session()->flash('mensaje', 'La persona fue inpugnada correctamente.');
            return back()->with('status', 200);
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollback();
            session()->flash('mensaje', 'No se pudo agregar los datos. Verifica que todos los campos estén completos y sean válidos.');
            return back()->with('status', 500);
        }
       
    }

    public function viewInpugacion(){
        $sancionadosInfo = sancionados::from('sancionados as s')
                ->select('ps.id_persona_sancionada',
                    'ps.nombre_completo',
                    'ps.apellidos',
                    'ps.curp',
                    's.id_sancionado',
                    's.numero_expediente',
                    's.fecha_resolucion',
                    's.id_catalogo_autoridades',
                    'ca.nombre_autoridad',
                    's.id_catalogo_sancionados',
                    'cs.nombre_sancion',
                    's.id_catalogo_dependencia',
                    'cd.nombre_dependencia',
                    's.created_at',
                    's.deprecated'
                )
                ->join('personas_sancionadas as ps', 'ps.id_persona_sancionada', '=', 's.id_persona_sancionada')
                ->join('catalogo_autoridades as ca', 'ca.id_catalogo_autoridades', '=', 's.id_catalogo_autoridades')
                ->join('catalogo_sanciones as cs', 'cs.id_catalogo_sanciones', '=', 's.id_catalogo_sancionados')
                ->join('catalogo_dependencia as cd', 'cd.id_catalogo_dependecia', '=', 's.id_catalogo_dependencia')
                ->orderBy('deprecated', 'ASC') 
                ->orderBy('created_at', 'DESC')
                ->get();
              /* ;$sqlQuery = $sancionadosInfo->toSql();
                dd ($sqlQuery); */
                 // Obtener las sanciones impugnadas
                $sancionesImpugnadas = Impugnacion::pluck('id_sancionado')->toArray();


                foreach ($sancionadosInfo as $d) {
                    $d->fecha_resolucion = Carbon::parse($d->fecha_resolucion)->locale('es')->isoFormat('LL');
                    $d->impugnada = in_array($d->id_sancionado, $sancionesImpugnadas);
                }
                //dd($sancionadosInfo);
                return view('Impugnacion', compact('sancionadosInfo'));
    
    }
}
