<?php

use App\Http\Controllers\Api\CommunityController;
use App\Http\Controllers\Api\TagsListController;
use App\Http\Controllers\Api\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('communities', [CommunityController::class, 'index'])->name('api.communities.index');
Route::get('tagslist', [TagsListController::class, 'tags'])->name('api.tags.whitelist');
Route::get('users', [UserController::class, 'index'])->name('api.users.index');
