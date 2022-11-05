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


        /** varibles rate limiting **/
    $cantPeticiones = env('CANTIDAD_PETICIONES_RUTA');
    $timeRuta = env('TIME_RUTA');




    Route::group([
        'middleware' => 'api'
    ], function ($router) use ($timeRuta, $cantPeticiones) {

        /**
         * Authentication Module
         */
        Route::group(['prefix' => 'auth'], function() {
            Route::post('/login', [AuthController::class, 'login']);
            Route::post('/register', [AuthController::class, 'register']);
            Route::post('/logout', [AuthController::class, 'logout']);
            Route::post('/refresh', [AuthController::class, 'refresh']);
            Route::get('/user-profile', [AuthController::class, 'userProfile']);
        });


        /**
         * Media Module
         */
        Route::middleware("throttle:".$cantPeticiones.','.$timeRuta)->group(function () {
            Route::get('/ficheros', [FicheroController::class, 'index']);
            Route::get('/ficheros/{fichero}', [FicheroController::class, 'show']);
        });

        Route::post('/ficheros', [FicheroController::class, 'store']);
        Route::put('/ficheros/{fichero}', [FicheroController::class, 'update']);
        Route::delete('/ficheros-logica/{fichero}', [FicheroController::class, 'delete']);
        Route::delete('/ficheros-fisica/{fichero}', [FicheroController::class, 'destroy']);

    });




