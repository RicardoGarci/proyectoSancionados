<?php

namespace App\Http\Controllers;

use App\Models\CatalogoAutoridade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CatalogoAutoridadeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $catalogo = CatalogoAutoridade::where('deprecated', 0)->get();
        return view('/CatalogoAutoridades')->with('catalogo', $catalogo);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try{
            $validator = Validator::make($request->all(), [
                'nombreAutoridad' => ['required', 'regex:/^[A-Za-z\s]+$/'],
            ]);

            if ($validator->fails()) {
                session()->flash('mensaje', 'El campo contiene caracteres especiales o números.');
                return back()->with('status', 400);
            }

            $catalogo = new CatalogoAutoridade;
            $catalogo->nombre_autoridad = $request->input('nombreAutoridad');
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
     * @param  \App\Models\CatalogoAutoridade  $catalogoAutoridade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{
            $validator = Validator::make($request->all(), [
                'nombreAutoridadEdit' => ['required', 'regex:/^[A-Za-z\s]+$/'],
            ]);

            if ($validator->fails()) {
                session()->flash('mensaje', 'El campo contiene caracteres especiales o números.');
                return back()->with('status', 400);
            }

            $dato = CatalogoAutoridade::find($id);
            $dato->nombre_autoridad = $request->input('nombreAutoridadEdit');
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
     * @param  \App\Models\CatalogoAutoridade  $catalogoAutoridade
     * @return \Illuminate\Http\Response
     */


    public function destroy($id){
        try {
            $dato = CatalogoAutoridade::find($id);
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
