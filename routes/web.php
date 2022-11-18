<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\sketchController;
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
    return view('welcome');
});
Route::get('sketch',[sketchController::class,'index']);
Route::post('storecanvas',[sketchController::class,'storecanvas']);
Route::get('list',[sketchController::class,'list']);
Route::get('drawpage/{id}',[sketchController::class,'drawPage']);
Route::get('template',[sketchController::class,'template']);
Route::get('templateview/{id}',[sketchController::class,'templateview']);
Route::post('savetemplate',[sketchController::class,'savetemplate']);
Route::get('joins',[sketchController::class,'joins']);
Route::get('drawtemplate',[sketchController::class,'drawtemplate']);
Route::get('drawtemplateview/{id}',[sketchController::class,'drawtemplateview']);
Route::get('merging',[sketchController::class,'merging']);

//sample
Route::get('sample',[sketchController::class,'sample']);
Route::get('test',[sketchController::class,'test']);