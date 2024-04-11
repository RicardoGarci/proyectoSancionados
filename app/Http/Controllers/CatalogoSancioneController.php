<?php

namespace App\Http\Controllers;

use App\Models\CatalogoSancione;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CatalogoSancioneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $catalogo = CatalogoSancione::where('deprecated', 0)->get();
        return view('/CatalogoSanciones')->with('catalogo', $catalogo);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        try{
            $validator = Validator::make($request->all(), [
                'nombreSancion' => ['required', 'regex:/^[A-Za-z\s]+$/'],
            ]);
        
            if ($validator->fails()) {
                session()->flash('mensaje', 'El campo contiene caracteres especiales o números.');
                return back()->with('status', 400);
            }

            $catalogo = new CatalogoSancione;
            $catalogo->nombre_sancion = $request->input('nombreSancion');
            $catalogo->save();
            session()->flash('mensaje','Se ha añadido correctamente.');
            return back()->with('status', 200);

        } catch (\Exception $e) {
            session()->flash('mensaje','Ha ocurrido un error al agregar los datos.');
            return back()->with('status', 500);
        }
        
        }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CatalogoSancione  $catalogoSancione
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $validator = Validator::make($request->all(), [
                'nombreSancionEdit' => ['required', 'regex:/^[A-Za-z\s]+$/'],
            ]);
        
            if ($validator->fails()) {
                session()->flash('mensaje', 'El campo contiene caracteres especiales o números.');
                return back()->with('status', 400);
            }

            $dato = CatalogoSancione::find($id);
            $dato->nombre_sancion = $request->input('nombreSancionEdit');
            $dato->save();

            session()->flash('mensaje','Los datos se han guardado correctamente.');
            return back()->with('status', 200);
        } catch (\Exception $e) {


            session()->flash('mensaje','Ha ocurrido un error al actualizar los datos.');
            return back()->with('status', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CatalogoSancione  $catalogoSancione
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        try {
            $dato = CatalogoSancione::find($id);
            $dato->deprecated ='1';
            $dato->save();
    
            session()->flash('mensaje', 'Se elimino correctamente.');
            return back()->with('status', 200);
        } catch (\Exception $e) {
    
            session()->flash('error', 'Ha ocurrido un error al marcar los datos como obsoletos.');
            return back()->with('status', 500);
        }
    }
}
