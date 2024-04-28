<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContratController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuichetController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('login', [AuthController::class,'login']);
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class,'me']);
    Route::get('/user', [UserController::class, 'getUser']);
});
Route::group([
    'middleware' => 'api',
], function ($router) {
    Route::Resource('contrats', ContratController::class);
    Route::get('contrattypes', [TypeController::class, 'index']);
    Route::get('/type/contracts/{type}', [TypeController::class, 'getContractsByType']);
    Route::get('/guichets', [GuichetController::class, 'index']);
    Route::get('/guichets/{id}', [GuichetController::class, 'show']);
    Route::post('/guichets', [GuichetController::class, 'store']);
    Route::put('/guichets/{id}', [GuichetController::class, 'update']);
    Route::delete('/guichets/{id}', [GuichetController::class, 'destroy']);
    Route::get('/type/contract_guichets/{contratId}', [ClientController::class, 'index']);
    Route::get('/contract_guichets/{id}', [ClientController::class, 'show']);
    Route::post('/contract_guichets', [ClientController::class, 'store']);
    Route::put('/contracts_guichets/{id}', [ClientController::class, 'update']);
    Route::delete('/contract_guichets/delete/{id}', [ClientController::class, 'destroy']);
    Route::delete('/contracts_guichets/delete_by_ids', [ClientController::class, 'deleteByIds']);
    Route::get('/contract-guichets-sum', [DashboardController::class, 'getContractGuichetsWithSum']);
    Route::get('/contract-guichets-recette-sum', [DashboardController::class, 'getContractGuichetsRecetteSum']);
    Route::get('/contracts-by-type', [DashboardController::class, 'contractsByType']);
    Route::get('/recent-contracts', [DashboardController::class, 'getRecentContracts']);
    Route::get('/best-contracts', [DashboardController::class, 'getBestContracts']);
    Route::get('/satisfactions', [DashboardController::class, 'getSatisfactions']);
    Route::post('/update-satisfactions', [DashboardController::class, 'updateSatisfactions']);
});


