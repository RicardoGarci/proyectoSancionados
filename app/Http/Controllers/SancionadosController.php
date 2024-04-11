<?php

namespace App\Http\Controllers;
use App\Models\CatalogoAutoridade;
use App\Models\CatalogoSancione;
use App\Models\CatalogoDependencia;
use App\Models\PersonasSancionadas;
use App\Models\Sancionados;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;



class SancionadosController extends Controller{

    public function viewSancionados(){
        $personasSancionadas = app(PersonasSancionadas::class)->obtenerPersonasSancionadas();
        $personasInfo = [];
        return view('EditSancionados', compact('personasSancionadas', 'personasInfo'));
    }

    public function loadPersonasSancionadas(Request $request)
    {
        $accion = $request->input('accion');

        if ($accion === 'cargar') {
            $idPersonaSancionada = $request->input('id_persona_sancionada');
            $personasInfo = sancionados::from('sancionados as s')
                ->select('ps.id_persona_sancionada',
                    'ps.nombre_completo',
                    'ps.apellidos',
                    'ps.curp',
                    'ps.rfc',
                    's.id_catalogo_dependencia',
                    'cd.nombre_dependencia',
                    's.cargo_servidor_publico',
                    's.id_sancionado',
                    's.numero_expediente',
                    's.monto',
                    's.duracion_resolucion',
                    's.fecha_resolucion',
                    's.fecha_inicio',
                    's.fecha_termino',
                    's.observaciones',
                    's.id_catalogo_autoridades',
                    'ca.nombre_autoridad',
                    's.id_catalogo_sancionados',
                    'cs.nombre_sancion',
                    's.created_at'
                )
                ->join('personas_sancionadas as ps', 'ps.id_persona_sancionada', '=', 's.id_persona_sancionada')
                ->join('catalogo_autoridades as ca', 'ca.id_catalogo_autoridades', '=', 's.id_catalogo_autoridades')
                ->join('catalogo_sanciones as cs', 'cs.id_catalogo_sanciones', '=', 's.id_catalogo_sancionados')
                ->join('catalogo_dependencia as cd', 'cd.id_catalogo_dependecia', '=', 's.id_catalogo_dependencia')
                ->where('s.deprecated', 0)
                ->where('ps.id_persona_sancionada', $idPersonaSancionada)
                ->get();
              // $sqlQuery = $personasInfo->toSql();
                //dd ($sqlQuery);


            $personasSancionadas = app(PersonasSancionadas::class)->obtenerPersonasSancionadas();
            $autoridadesEdit = app(CatalogoAutoridade::class)->obtenerAutoridades();
            $sancionesEdit = app(CatalogoSancione::class)->obtenerSanciones();
            $dependenciasEdit = app(CatalogoDependencia::class)->obtenerDependencia();

            return view('EditSancionados', compact('personasSancionadas', 'personasInfo', 'autoridadesEdit', 'sancionesEdit','dependenciasEdit'));
            //return $personasInfo;

        }elseif ($accion === 'guardar' ){
            //dd($request->all());
            //dd($request->input('sanciones_adicionalesEdit'));

            //validacion de las datos de la curp, aqui se valida para que se peuda actualizar o/y agregar una sancion
            //ademas de que no se puedan repetir la CURP en varios registros
            $validator = Validator::make(
                ['txtEditCurp' => $request->input('txtEditCurp')],
                [
                    'txtEditCurp' => [
                        Rule::unique('personas_sancionadas', 'curp')->ignore($request->input('idPersonaS'), 'id_persona_sancionada'),
                    ],
                ],
                [
                    'txtEditCurp.unique' => 'La CURP ya existe en nuestros registros.',
                ]
            );

            if ($validator->fails()) {
                session()->flash('mensaje', $validator->errors());
                //dd(session('mensaje'));
                return redirect()->route('sancionados.view')->with('status', 400);
            }

            DB::beginTransaction();
            try {
                $idPersonaSancionada = $request->input('idPersonaS');
                $personaSancionada = PersonasSancionadas::find($idPersonaSancionada);

                if ($personaSancionada) {
                    $personaSancionada->update([
                        'nombre_completo' => $request->input('txtEditNombreCompleto'),
                        'apellidos' => $request->input('txtEditApellidos'),
                        'curp' => $request->input('txtEditCurp'),
                        'rfc' => $request->input('txtEditRFC'),
                    ]);

                    
                    foreach ($request->input('sanciones_adicionalesEdit') as $key => $sancion) {
                        // Verificar si el ID está presente y no es null
                        if (!is_null($sancion["idSancionadoEdit"])) {
                            $sancionExistente = Sancionados::find($sancion["idSancionadoEdit"]);

                            if ($sancionExistente) {
                                $fecha_resolucion = null;
                                if (!empty($sancion['dateEditResolucion'])) {
                                    $fecha_resolucion = date("Y-m-d", strtotime(str_replace('/', '-', $sancion['dateEditResolucion'])));
                                }
                                $datosActualizados = [
                                    'numero_expediente' => $sancion['txtEditNExpediente'],
                                    'cargo_servidor_publico' => $sancion['txtEditCargoServidorPublico'],
                                    'monto' => $sancion['txtEditMonto'],
                                    'duracion_resolucion' => $sancion['txtEditDResolucion'],
                                    'fecha_resolucion' => $fecha_resolucion,
                                    $fechaInicio = isset($sancion['dateEditInicio']) ? $sancion['dateEditInicio'] : '',
                                    $fechaTermino = isset($sancion['dateEditTermino']) ? $sancion['dateEditTermino'] : '',
                                    'fecha_inicio' => !empty($fechaInicio) ? date("Y-m-d", strtotime(str_replace('/', '-', $fechaInicio))) : null,
                                    'fecha_termino' => !empty($fechaTermino) ? date("Y-m-d", strtotime(str_replace('/', '-', $fechaTermino))) : null,
                                //'fecha_inicio' => date("Y-m-d", strtotime(str_replace('/', '-', $sancion['dateEditInicio']))),
                                //'fecha_termino' => date("Y-m-d", strtotime(str_replace('/', '-', $sancion['dateEditTermino']))),
                                    'id_catalogo_autoridades' => $sancion['slcEditAutoridad'],
                                    'id_catalogo_sancionados' => $sancion['slcEditSancion'],
                                    'id_catalogo_dependencia' => $sancion['slcEditDependencia'],
                                    'observaciones' => $sancion['txtEditObservaciones']
                                ];
                             
                                

                                $cambios = array_diff_assoc($datosActualizados, $sancionExistente->toArray());

                                if (!empty($cambios)) {
                                    
                                    $sancionExistente->update($datosActualizados);
                                    
                                }
                            
                            }
                        } else {
                            // Crear nuevo registro ya que idSancionadoEdit es null
                            $nuevaSancion = new Sancionados;
                            $nuevaSancion->id_persona_sancionada = $idPersonaSancionada;
                            $nuevaSancion->id_catalogo_autoridades = $sancion['slcEditAutoridad'];
                            $nuevaSancion->id_catalogo_sancionados = $sancion['slcEditSancion'];
                            $nuevaSancion->id_catalogo_dependencia = $sancion['slcEditDependencia'];
                            $nuevaSancion->id_user = Auth::user()->id;
                            $nuevaSancion->numero_expediente = $sancion['txtEditNExpediente'];
                            $nuevaSancion->cargo_servidor_publico = $sancion['txtEditCargoServidorPublico'];
                            $nuevaSancion->monto = $sancion['txtEditMonto'];
                            $nuevaSancion->duracion_resolucion = $sancion['txtEditDResolucion'];
                            $nuevaSancion->fecha_resolucion = null;
                            if (!empty($sancion['dateEditResolucion'])) {
                                $nuevaSancion->fecha_resolucion = date("Y-m-d", strtotime(str_replace('/', '-', $sancion['dateEditResolucion'])));
                            }
                            $fechaInicio = isset($sancion['dateEditInicio']) ? $sancion['dateEditInicio'] : '';
                            $fechaTermino = isset($sancion['dateEditTermino']) ? $sancion['dateEditTermino'] : '';
                            $nuevaSancion->fecha_inicio = !empty($fechaInicio) ? date("Y-m-d", strtotime(str_replace('/', '-', $fechaInicio))) : null;
                            $nuevaSancion->fecha_termino = !empty($fechaTermino) ? date("Y-m-d", strtotime(str_replace('/', '-', $fechaTermino))) : null;
                            $nuevaSancion->observaciones = $sancion['txtEditObservaciones'];
                            $nuevaSancion->save();
                           
                        }
                    }
                }
                DB::commit();
                session()->flash('mensaje', 'Se ha añadido correctamente.');
                return redirect()->route('sancionados.view')->with('status', 200);
            } catch (\Exception $e) {
                //dd($e->getMessage());
                DB::rollback();
                session()->flash('mensaje', 'No se pudo agregar los datos. Verifica que todos los campos estén completos y sean válidos.');
                return redirect()->route('sancionados.view')->with('status', 500);
            }
        }
    }

    public function index(){
        $autoridades = app(CatalogoAutoridade::class)->obtenerAutoridades();
        $sanciones = app(CatalogoSancione::class)->obtenerSanciones();
        $dependencias = app(CatalogoDependencia::class)->obtenerDependencia();
        return view('/AddSancionado', compact('autoridades','sanciones','dependencias'));

    }

    public function store(Request $request){

        
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'txtCurp' => 'required|regex:/^([A-Z&Ñ]{4})([0-9]{6})([HM])([A-Z]{5})([0-9A-Z]{2})$/|unique:personas_sancionadas,curp',
            ],[
            'txtCurp.required' => 'El campo CURP es obligatorio.',
            'txtCurp.regex' => 'La CURP no cumple con los parametros para estar certificada',
            'txtCurp.unique' => 'La CURP ya existe en nuestros registros.'
        ]);
        if ($validator->fails()) {

            session()->flash('mensaje', $validator->errors());
            // dd(session('mensaje'));
            return back()->with('status', 400);
        }
        DB::beginTransaction();
        try {
            // Guardar en la tabla personas_sancionadas
            $personaSancionada = new PersonasSancionadas;
            $personaSancionada->nombre_completo = $request->input('txtNombreCompleto');
            $personaSancionada->apellidos = $request->input('txtApellidos');
            $personaSancionada->curp = $request->input('txtCurp');
            $personaSancionada->rfc = $request->input('txtRFC');
            $personaSancionada->save();
            // Obtener el ID de la persona sancionada recién creada
            $idPersonaSancionada = $personaSancionada->id_persona_sancionada;
            if ($request->has('sanciones_adicionales')) {
              
                $sancionesAdicionales = $request->input('sanciones_adicionales');
                foreach ($sancionesAdicionales as $sancionAdicional) {
                    $nuevaSancion = new Sancionados;
                    $nuevaSancion->id_persona_sancionada = $idPersonaSancionada;
                    $nuevaSancion->id_catalogo_autoridades = $sancionAdicional['slcAutoridad'];
                    $nuevaSancion->id_catalogo_sancionados  = $sancionAdicional['slcSancion'];
                    $nuevaSancion->id_catalogo_dependencia  = $sancionAdicional['slcDependencia'];
                    $nuevaSancion->id_user = Auth::user()->id;
                    $nuevaSancion->cargo_servidor_publico = $sancionAdicional['txtCargoServidorPublico'];
                    $nuevaSancion->numero_expediente = $sancionAdicional['txtNExpediente'];
                    $nuevaSancion->monto = $sancionAdicional['txtMonto'];
                    $nuevaSancion->duracion_resolucion = $sancionAdicional['txtDResolucion'];
                    $nuevaSancion->fecha_resolucion = date("Y-m-d", strtotime(str_replace('/', '-', $sancionAdicional['dateResolucion'])));
                    //si el valor que recibe es vacio returnara null
                    $fechaInicio = isset($sancionAdicional['dateInicio']) ? $sancionAdicional['dateInicio'] : '';
                    $fechaTermino = isset($sancionAdicional['dateTermino']) ? $sancionAdicional['dateTermino'] : '';
                    $nuevaSancion->fecha_inicio = !empty($fechaInicio) ? date("Y-m-d", strtotime(str_replace('/', '-', $fechaInicio))) : null;
                    $nuevaSancion->fecha_termino = !empty($fechaTermino) ? date("Y-m-d", strtotime(str_replace('/', '-', $fechaTermino))) : null;
                    $nuevaSancion->observaciones = $sancionAdicional['txtObservaciones'];
                    $nuevaSancion->save();

                }
            }
            DB::commit();
            session()->flash('mensaje', 'Se ha añadido correctamente.');
            return back()->with('status', 200);
        } catch (\Exception $e) {
            //dd($e->getMessage());
            DB::rollback();
            session()->flash('mensaje', 'No se pudo agregar los datos. Verifica que todos los campos estén completos y sean válidos.');
            return back()->with('status', 500);
        }
    }

}
