<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Agence\AgenceController;
use App\Http\Controllers\AgentAuthController;
use App\Http\Controllers\ClientAuthController;
use App\Http\Controllers\Property\PropertyController;
use App\Http\Controllers\Property\SaveController;
use App\Http\Controllers\User\AdminController;
use App\Http\Controllers\User\AgentController;
use App\Http\Controllers\User\ClientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::middleware('auth:sanctum')->get('/user/admin', function (Request $request) {
    return Auth::user();
});
Route::middleware('auth:sanctum')->get('/user/client', function (Request $request) {
    if (Auth::user()->adresse_id == null)
        return [
            'user' => Auth::user(),
            'adresse' => null,
        ];
    return [
        'user' => Auth::user(),
        'adresse' => Auth::user()->adresse,
    ];
});
Route::middleware('auth:sanctum')->get('/user/agent', function (Request $request) {
    return Auth::user();
});
Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResources([
        'client/auth' => ClientController::class,
        'admin/auth' => AdminController::class,
        'agent/auth' => AgentController::class,
        // 'agence' => AgenceController::class,
        'save' => SaveController::class
    ]);

    Route::post('saved', [SaveController::class, 'savedManage']);
    Route::post('save/property', [SaveController::class, 'saveProp']);
    Route::post('unsave/property', [SaveController::class, 'unsaveProp']);

    Route::get('client/logout', [ClientAuthController::class, 'logout']);
    Route::post('client/role', [ClientAuthController::class, 'checkClientRole']);
    Route::post('client/infos/update', [ClientAuthController::class, 'updateInfosApi']);
    Route::post('client/pwd/update', [ClientAuthController::class, 'updatePwdApi']);
    Route::post('client/pwd/existence', [ClientAuthController::class, 'pwdExistence']);
    Route::post('client/existence/user', [ClientAuthController::class, 'isEmailFreeUsApi']);

    Route::get('auth-property/{id}', [PropertyController::class, 'showAuth']);


    Route::get('aproperties/agfirst/{key}/{exclude}', [PropertyController::class, 'propAgCountApi']);
    Route::get('aproperties/ag/{key}/{exclude}', [PropertyController::class, 'propAgApi']);
    Route::get('aproperties/villesfirst/{key}/{id}', [PropertyController::class, 'propVilleFirstApi']);
    Route::get('aproperties/villes/{key}/{id}', [PropertyController::class, 'propVilleApi']);
    Route::get('aproperties/search/{key}', [PropertyController::class, 'searchKeyApi']);
    Route::post('aproperties/search', [PropertyController::class, 'searchApi']);
    Route::get('aproperties/bytype/{type}', [PropertyController::class, 'showByType']);
    Route::get('aproperties/bytype/skip/{type}', [PropertyController::class, 'showByTypeSkip']);
    Route::get('aproperty/agent/{show}', [PropertyController::class, 'showOwn']);
    Route::get('aproperty/visit/{id}', [PropertyController::class, 'visitApi']);
    Route::post('aproperties/viewed', [PropertyController::class, 'viewedApi']);
    // need auth
    // agent
    Route::post('aproperty/update', [PropertyController::class, 'updateApi']);
    Route::get('aproperty/{mark}/{as}/{id}', [PropertyController::class, 'soldOrRent']);
});


Route::apiResources([
    'property' => PropertyController::class,
]);
Route::apiResources([
    'agent' => AgentAuthController::class,
    'client' => ClientAuthController::class,
    'admin' => AdminAuthController::class,
]);

Route::middleware('auth:sanctum')->get('properties/fav/{key}/{sort}', [PropertyController::class, 'favPropApi']);


Route::get('client/logout/notoken/{user_id}/{token_id}', [ClientAuthController::class, 'logoutNoToken']);
Route::post('client/login', [ClientAuthController::class, 'login']);
Route::post('client/existence', [ClientAuthController::class, 'isEmailFreeApi']);


Route::post('agent/existence', [AgentAuthController::class, 'isEmailFreeApi']);

Route::post('agence/existence', [AgenceController::class, 'isEmailFreeApi']);


Route::get('properties/agfirst/{key}/{exclude}', [PropertyController::class, 'propAgCountApi']);
Route::get('properties/ag/{key}/{exclude}', [PropertyController::class, 'propAgApi']);
Route::get('properties/villesfirst/{key}/{id}', [PropertyController::class, 'propVilleFirstApi']);
Route::get('properties/villes/{key}/{id}', [PropertyController::class, 'propVilleApi']);
Route::get('properties/search/{key}', [PropertyController::class, 'searchKeyApi']);
Route::post('properties/search', [PropertyController::class, 'searchApi']);
Route::get('properties/bytype/{type}', [PropertyController::class, 'showByType']);
Route::get('properties/bytype/skip/{type}', [PropertyController::class, 'showByTypeSkip']);
Route::get('property/agent/{show}', [PropertyController::class, 'showOwn']);
Route::get('property/visit/{id}', [PropertyController::class, 'visitApi']);
Route::post('properties/viewed', [PropertyController::class, 'viewedApi']);
// need auth
// agent
Route::post('property/update', [PropertyController::class, 'updateApi']);
Route::get('property/{mark}/{as}/{id}', [PropertyController::class, 'soldOrRent']);
