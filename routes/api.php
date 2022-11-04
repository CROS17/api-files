<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\FicheroController;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
        /** varibles rate limiting **/
    $cantPeticiones = env('CANTIDAD_PETICIONES_RUTA');
    $timeRuta = env('TIME_RUTA');

    Route::group([
        'middleware' => 'api',
        'prefix' => 'auth'
    ], function ($router) {

        /**  user login **/
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::get('/user-profile', [AuthController::class, 'userProfile']);


        /**  user files **/
    });

//        Route::middleware(['auth'])->group(function () {});
        Route::middleware("throttle:".$cantPeticiones.','.$timeRuta)->group(function () {
            Route::get('/ficheros', [FicheroController::class, 'index']);
            Route::get('/ficheros/{fichero}', [FicheroController::class, 'show']);
        });

        Route::post('/ficheros', [FicheroController::class, 'store']);
        Route::put('/ficheros/{fichero}', [FicheroController::class, 'update']);
        Route::delete('/ficheros/{fichero}', [FicheroController::class, 'destroy']);
        Route::delete('/ficheros/{fichero}', [FicheroController::class, 'delete']);

//        Route::apiResource('/ficheros', FicheroController::class);

