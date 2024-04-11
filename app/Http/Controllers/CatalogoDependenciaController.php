<?php

namespace App\Http\Controllers;

use App\Models\CatalogoDependencia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Auth;

class CatalogoDependenciaController extends Controller
{
    
    public function index()
    {
        $catalogo = CatalogoDependencia::where('deprecated', 0)->get();
        return view('/CatalogoDependencia')->with('catalogo', $catalogo);
    }

   
    public function store(Request $request)
    {

        try{
            $validator = Validator::make($request->all(), [
                'nombreDependencia' => ['required', 'regex:/^[A-Za-z\s]+$/'],
                'nomenclaturaDependencia' => ['required', 'regex:/^[A-Za-z\s]+$/']
            ]);

            if ($validator->fails()) {
                session()->flash('mensaje', 'El campo contiene caracteres especiales o números.');
                return back()->with('status', 400);
            }

            $catalogo = new CatalogoDependencia;
            $catalogo->nombre_dependencia = $request->input('nombreDependencia');
            $catalogo->nomenclatura = $request->input('nomenclaturaDependencia');
            $catalogo->save();
            session()->flash('mensaje','Se ha añadido correctamente.');
            return back()->with('status', 200);

        } catch (\Exception $e) {
            
            session()->flash('mensaje','Ha ocurrido un error al agregar los datos.');
            return back()->with('status', 500);
        }


    }


    public function update(Request $request, $id)
    {
        try{
            $validator = Validator::make($request->all(), [
                'nombreDependenciaEdit' => ['nullable', 'regex:/^[A-Za-z\s]+$/'],
                'nomenclaturaDependenciaEdit' => ['nullable', 'regex:/^[A-Za-z\s]+$/']
            ]);

            if ($validator->fails()) {
                session()->flash('mensaje', 'El campo contiene caracteres especiales o números.');
                return back()->with('status', 400);
            }

            $dato = CatalogoDependencia::find($id);

            if ($request->filled('nombreDependenciaEdit')) {
                $dato->nombre_dependencia = $request->input('nombreDependenciaEdit');
            }
            if ($request->filled('nomenclaturaDependenciaEdit')) {
                $dato->nomenclatura = $request->input('nomenclaturaDependenciaEdit');
            }
            $dato->save();
            session()->flash('mensaje','Los datos se han guardado correctamente.');
            return back()->with('status', 200);
        } catch (\Exception $e) {
            //dd($e->getMessage());
            session()->flash('mensaje','Ha ocurrido un error al actualizar los datos.');
            return back()->with('status', 500);
        }

    }

    public function destroy($id){
        try {
            $dato = CatalogoDependencia::find($id);
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
