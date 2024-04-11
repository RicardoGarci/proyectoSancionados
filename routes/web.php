<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
    //return view('welcome');
});

Route::middleware('auth')->group(function () {
//ruta de ada catalogo para vista,insertar,editar y eliminar registro
Route::resource('/catalogo_autoridades', 'App\Http\Controllers\CatalogoAutoridadeController');
Route::resource('/catalogo_sanciones', 'App\Http\Controllers\CatalogoSancioneController');
Route::resource('/catalogo_dependencia', 'App\Http\Controllers\CatalogoDependenciaController');
//ruta para la parte de sancionados en table,add carga y edicion 
Route::resource('/sancionados', 'App\Http\Controllers\SancionadosController');
Route::get('/viewSancionados', 'App\Http\Controllers\SancionadosController@viewSancionados')->name('sancionados.view');
Route::post('/loadDatosPersonas', 'App\Http\Controllers\SancionadosController@loadPersonasSancionadas')->name('sancionados.cargarDatos');
//ruta para la inpugnacion de sancionados 
Route::get('/viewImpugnacion', 'App\Http\Controllers\ImpugnacionController@viewInpugacion')->name('impugnacion.view');
Route::post('/impugnar', 'App\Http\Controllers\ImpugnacionController@impugnar')->name('impugnar.agregar');
Route::get('/impugnar/activar/{id}', 'App\Http\Controllers\ImpugnacionController@activarImpugnar')->name('impugnar.activar');
Route::get('/impugnar/load/{id}', 'App\Http\Controllers\ImpugnacionController@loadImpugnar')->name('impugnar.load');
Route::get('/impugnar/loadDocumentos/{id_sancionado}', 'App\Http\Controllers\ImpugnacionController@loadDocumentosImpugnacion')->name('impugnar.loadDocumentosImpugnacion');
Route::get('/impugnar/loadPDF/{id}', 'App\Http\Controllers\ImpugnacionController@loadPDFimpugnar')->name('impugnarPDF');
//ruta para el reporte principal 
Route::get('/dashboard', 'App\Http\Controllers\ReporteDashboardController@index')->name('dashboard');
Route::get('/obtenerDatosFiltrados', 'App\Http\Controllers\ReporteDashboardController@obtenerDatosFiltrados')->name('obtener.datos.filtrados');
//Ruta de LOGS
Route::get('impugnacion/logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);


});
require __DIR__.'/auth.php';


