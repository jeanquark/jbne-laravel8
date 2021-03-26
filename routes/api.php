<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
Route::middleware('role:lawyer')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('role:admin')->get('/v1/calendars', [App\Http\Controllers\CalendarsController::class, 'index']);

Route::middleware('role:student|lawyer')->get('/v1/files', [App\Http\Controllers\FilesController::class, 'index']);

// Permanences
Route::apiResource('/v1/permanences', App\Http\Controllers\PermanencesController::class);

Route::apiResource('/v1/folders', App\Http\Controllers\FoldersController::class);
Route::post('/v1/folders/destroy', [
    'as' => 'folders.destroy', 
    'uses' => 'App\Http\Controllers\FoldersController@destroy'
]);

Route::apiResource('/v1/files', App\Http\Controllers\FilesController::class);
Route::get('/v1/files/{file}', [App\Http\Controllers\FilesController::class, 'download'])->where('file', '.*');
// Route::get('/v1/files/action/getsize?path={filePath}', [App\Http\Controllers\FilesController::class, 'getSize'])->where('filePath', '.*');
Route::post('/v1/files/size', [App\Http\Controllers\FilesController::class, 'getSize']);
Route::post('/v1/files/last-modified', [App\Http\Controllers\FilesController::class, 'getLastModified']);
Route::post('/v1/files/destroy', [
    'as' => 'files.destroy', 
    'uses' => 'App\Http\Controllers\FilesController@destroy'
]);

// Route::get('/v1/permanences', [App\Http\Controllers\PermanencesController::class, 'index']);
// Route::put('/v1/permanences/update', [App\Http\Controllers\PermanencesController::class, 'update']);
// Route::get('/v1/permanences/{year}/{quarter}', [App\Http\Controllers\PermanencesController::class, 'index']);