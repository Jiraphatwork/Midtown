<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Webpanel as Webpanel;
use App\Http\Controllers\Member as Member;
use App\Http\Controllers\Frontend as Frontend;
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

//========== Session Lang (กรณี 2 ภาษา) ============
// Route::get('/set/lang/{lang}', [Frontend\HomeController::class, 'setLang']);
// Route::get('/', function () {
//     $default = 'th';
//     $lang = Session('lang');
//     if ($lang == "") {
//         Session::put('lang', $default);
//         return redirect("/$default");
//     } else {
//         return redirect("/$lang");
//     }
// });
// Route::group(['middleware' => ['Language']], function () {
//     $locale = ['th', 'en', 'jp'];
//     foreach ($locale as $lang) {
//         Route::prefix($lang)->group(function () {
//             Route::get('', [Frontend\HomeController::class, 'index']);
//         });
//     }
// });
//========== Session Lang ============


//====================  ====================
//================  Backend ================
//====================  ====================

Route::prefix('log')->group(function () {
    Route::get('/', [Webpanel\Log\LogController::class, 'index']);
    Route::get('/show-log', [Webpanel\Log\LogController::class, 'show_log']);
});


Route::get('/', [Frontend\HomeController::class, 'index']);
Route::get('/login', [Frontend\HomeController::class, 'login']);
Route::post('/login', [Frontend\AuthController::class, 'postLogin']);

Route::post('/ajax/getProvince', [Frontend\AjaxController::class, 'getProvince']);
Route::post('/ajax/getAmupur', [Frontend\AjaxController::class, 'getAmupur']);
Route::post('/ajax/getTambon', [Frontend\AjaxController::class, 'getTambon']);


// USER

Route::group(['middleware' => ['User']], function () {
    Route::get('/logout', [Frontend\AuthController::class, 'logout']);
});



require('web-backend.php');
