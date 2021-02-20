<?php

use App\Http\Controllers\StorageController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
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


Route::get('image/{filename}', [StorageController::class,'displayImage'])->name('image.displayImage');

Route::get('files/{file_name}', function ($file_name = null) {
    $path = storage_path('files/' . $file_name);
 
    if (file_exists($path)) {
        return Response::download($path);
    }
});