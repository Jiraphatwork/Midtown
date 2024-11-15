<?php 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Webpanel as Webpanel;
use App\Http\Controllers\Functions as Functions;

 
Route::get('webpanel/login', [Webpanel\AuthController::class, 'getLogin']);
Route::post('webpanel/login', [Webpanel\AuthController::class, 'postLogin']);
Route::get('webpanel/logout', [Webpanel\AuthController::class, 'logOut']);



Route::group(['middleware' => ['Webpanel']], function () {
    Route::prefix('webpanel')->group(function () {
        Route::get('/', [Webpanel\DashboardController::class, 'index']);

        Route::prefix('administrator')->group(function () {
            Route::prefix('user')->group(function () {
                Route::get('/', [Webpanel\Administrator\UserController::class, 'index']);
                Route::get('/add', [Webpanel\Administrator\UserController::class, 'add']);
                Route::post('/add', [Webpanel\Administrator\UserController::class, 'insert']);
                Route::get('/edit/{id}', [Webpanel\Administrator\UserController::class, 'edit'])->where(['id' => '[0-9]+']);
                Route::post('/edit/{id}', [Webpanel\Administrator\UserController::class, 'update'])->where(['id' => '[0-9]+']);
                Route::get('/destroy/{id}', [Webpanel\Administrator\UserController::class, 'destroy'])->where(['id' => '[0-9]+']);
                Route::get('/status/{id}', [Webpanel\Administrator\UserController::class, 'status'])->where(['id' => '[0-9]+']);
            });

            Route::prefix('permission')->group(function () {
                Route::get('/', [Webpanel\Administrator\PermissionController::class, 'index']);
                Route::get('/add', [Webpanel\Administrator\PermissionController::class, 'add']);
                Route::post('/add', [Webpanel\Administrator\PermissionController::class, 'insert']);
                Route::get('/edit/{id}', [Webpanel\Administrator\PermissionController::class, 'edit'])->where(['id' => '[0-9]+']);
                Route::post('/edit/{id}', [Webpanel\Administrator\PermissionController::class, 'update'])->where(['id' => '[0-9]+']);
                Route::get('/destroy/{id}', [Webpanel\Administrator\PermissionController::class, 'destroy'])->where(['id' => '[0-9]+']);
                Route::get('/status/{id}', [Webpanel\Administrator\PermissionController::class, 'status'])->where(['id' => '[0-9]+']);
            });
  
        });
        Route::prefix('reserve_history')->group(function () {
            Route::get('/', [Webpanel\Reserve_history_controller::class, 'index'])->name('reserve_history.index');   
            Route::get('/add', [Webpanel\Reserve_history_controller::class, 'add'])->name('reserve_history.add');           
            Route::post('/add', [Webpanel\Reserve_history_controller::class, 'insert'])->name('reserve_history.insert'); 
            Route::get('/edit/{id}', [Webpanel\Reserve_history_controller::class, 'edit'])->where(['id' => '[0-9]+']); 
            Route::post('/edit/{id}', [Webpanel\Reserve_history_controller::class, 'update'])->where(['id' => '[0-9]+']); 
            Route::get('/destroy/{id}', [Webpanel\Reserve_history_controller::class, 'destroy'])->where(['id' => '[0-9]+']); 
            Route::get('/status/{id}', [Webpanel\Reserve_history_controller::class, 'status'])->where(['id' => '[0-9]+']); 
        });
        

        Route::prefix('calendar')->group(function () {
            Route::get('/', [Webpanel\CalendarController::class, 'index']);
            Route::get('/add', [Webpanel\CalendarController::class, 'add']);
            Route::post('/add', [Webpanel\CalendarController::class, 'insert']);
            Route::get('/edit/{id}', [Webpanel\CalendarController::class, 'edit'])->where(['id' => '[0-9]+']);
            Route::post('/edit/{id}', [Webpanel\CalendarController::class, 'update'])->where(['id' => '[0-9]+']);
            Route::get('/destroy/{id}', [Webpanel\CalendarController::class, 'destroy'])->where(['id' => '[0-9]+']);
            Route::get('/status/{id}', [Webpanel\CalendarController::class, 'status'])->where(['id' => '[0-9]+']);
        });

        Route::prefix('ordinary_customer')->group(function () {
            Route::get('/', [Webpanel\Ordinary_customerController::class, 'index']);
            Route::get('/add', [Webpanel\Ordinary_customerController::class, 'add']);
            Route::post('/add', [Webpanel\Ordinary_customerController::class, 'insert']);
            Route::get('/edit/{id}', [Webpanel\Ordinary_customerController::class, 'edit'])->where(['id' => '[0-9]+']);
            Route::post('/edit/{id}', [Webpanel\Ordinary_customerController::class, 'update'])->where(['id' => '[0-9]+']);
            Route::get('/destroy/{id}', [Webpanel\Ordinary_customerController::class, 'destroy'])->where(['id' => '[0-9]+']);
            Route::get('/status/{id}', [Webpanel\Ordinary_customerController::class, 'status'])->where(['id' => '[0-9]+']);
        });

        Route::prefix('organization_customer')->group(function () {
            Route::get('/', [Webpanel\organization_customerController::class, 'index']);
            Route::get('/add', [Webpanel\organization_customerController::class, 'add']);
            Route::post('/add', [Webpanel\organization_customerController::class, 'insert']);
            Route::get('/edit/{id}', [Webpanel\organization_customerController::class, 'edit'])->where(['id' => '[0-9]+']);
            Route::post('/edit/{id}', [Webpanel\organization_customerController::class, 'update'])->where(['id' => '[0-9]+']);
            Route::get('/destroy/{id}', [Webpanel\organization_customerController::class, 'destroy'])->where(['id' => '[0-9]+']);
            Route::get('/status/{id}', [Webpanel\organization_customerController::class, 'status'])->where(['id' => '[0-9]+']);
        });

        Route::prefix('agent_customer')->group(function () {
            Route::get('/', [Webpanel\Agent_customerController::class, 'index']);
            Route::get('/add', [Webpanel\Agent_customerController::class, 'add']);
            Route::post('/add', [Webpanel\Agent_customerController::class, 'insert']);
            Route::get('/edit/{id}', [Webpanel\Agent_customerController::class, 'edit'])->where(['id' => '[0-9]+']);
            Route::post('/edit/{id}', [Webpanel\Agent_customerController::class, 'update'])->where(['id' => '[0-9]+']);
            Route::get('/destroy/{id}', [Webpanel\Agent_customerController::class, 'destroy'])->where(['id' => '[0-9]+']);
            Route::get('/status/{id}', [Webpanel\Agent_customerController::class, 'status'])->where(['id' => '[0-9]+']);
        });
        Route::prefix('data_equipment')->group(function () {
            Route::get('/', [Webpanel\Data_equipmentController::class, 'index']);
            Route::get('/add', [Webpanel\Data_equipmentController::class, 'add']);
            Route::post('/add', [Webpanel\Data_equipmentController::class, 'insert']);
            Route::get('/edit/{id}', [Webpanel\Data_equipmentController::class, 'edit'])->where(['id' => '[0-9]+']);
            Route::post('/edit/{id}', [Webpanel\Data_equipmentController::class, 'update'])->where(['id' => '[0-9]+']);
            Route::get('/destroy/{id}', [Webpanel\Data_equipmentController::class, 'destroy'])->where(['id' => '[0-9]+']);
            Route::get('/status/{id}', [Webpanel\Data_equipmentController::class, 'status'])->where(['id' => '[0-9]+']);
        });

        Route::prefix('promotion')->group(function () {
            Route::get('/', [Webpanel\promotionController::class, 'index']);
            Route::get('/add', [Webpanel\promotionController::class, 'add']);
            Route::post('/add', [Webpanel\promotionController::class, 'insert']);
            Route::get('/edit/{id}', [Webpanel\promotionController::class, 'edit'])->where(['id' => '[0-9]+']);
            Route::post('/edit/{id}', [Webpanel\promotionController::class, 'update'])->where(['id' => '[0-9]+']);
            Route::get('/destroy/{id}', [Webpanel\promotionController::class, 'destroy'])->where(['id' => '[0-9]+']);
            Route::get('/status/{id}', [Webpanel\promotionController::class, 'status'])->where(['id' => '[0-9]+']);
        });

        Route::prefix('data_contact')->group(function () {
            Route::get('/', [Webpanel\Data_contactController::class, 'index']);
            Route::get('/add', [Webpanel\Data_contactController::class, 'add']);
            Route::post('/add', [Webpanel\Data_contactController::class, 'insert']);
            Route::get('/edit/{id}', [Webpanel\Data_contactController::class, 'edit'])->where(['id' => '[0-9]+']);
            Route::post('/edit/{id}', [Webpanel\Data_contactController::class, 'update'])->where(['id' => '[0-9]+']);
            Route::get('/destroy/{id}', [Webpanel\Data_contactController::class, 'destroy'])->where(['id' => '[0-9]+']);
            Route::get('/status/{id}', [Webpanel\Data_contactController::class, 'status'])->where(['id' => '[0-9]+']);
        });

        Route::prefix('settingrefund')->group(function () {
            Route::get('/', [Webpanel\SettingrefundController::class, 'index']);
            Route::get('/add', [Webpanel\SettingrefundController::class, 'add']);
            Route::post('/add', [Webpanel\SettingrefundController::class, 'insert']);
            Route::get('/edit/{id}', [Webpanel\SettingrefundController::class, 'edit'])->where(['id' => '[0-9]+']);
            Route::post('/edit/{id}', [Webpanel\SettingrefundController::class, 'update'])->where(['id' => '[0-9]+']);
            Route::get('/destroy/{id}', [Webpanel\SettingrefundController::class, 'destroy'])->where(['id' => '[0-9]+']);
            Route::get('/status/{id}', [Webpanel\SettingrefundController::class, 'status'])->where(['id' => '[0-9]+']);
        });

        Route::prefix('settingqrcode')->group(function () {
            Route::get('/', [Webpanel\SettingqrcodeController::class, 'index']);
            Route::get('/add', [Webpanel\SettingqrcodeController::class, 'add']);
            Route::post('/add', [Webpanel\SettingqrcodeController::class, 'insert']);
            Route::get('/edit/{id}', [Webpanel\SettingqrcodeController::class, 'edit'])->where(['id' => '[0-9]+']);
            Route::post('/edit/{id}', [Webpanel\SettingqrcodeController::class, 'update'])->where(['id' => '[0-9]+']);
            Route::get('/destroy/{id}', [Webpanel\SettingqrcodeController::class, 'destroy'])->where(['id' => '[0-9]+']);
            Route::get('/status/{id}', [Webpanel\SettingqrcodeController::class, 'status'])->where(['id' => '[0-9]+']);
        });

        Route::prefix('settingmembership')->group(function () {
            Route::get('/', [Webpanel\SettingmembershipController::class, 'index']);
            Route::get('/add', [Webpanel\SettingmembershipController::class, 'add']);
            Route::post('/add', [Webpanel\SettingmembershipController::class, 'insert']);
            Route::get('/edit/{id}', [Webpanel\SettingmembershipController::class, 'edit'])->where(['id' => '[0-9]+']);
            Route::post('/edit/{id}', [Webpanel\SettingmembershipController::class, 'update'])->where(['id' => '[0-9]+']);
            Route::get('/destroy/{id}', [Webpanel\SettingmembershipController::class, 'destroy'])->where(['id' => '[0-9]+']);
            Route::get('/status/{id}', [Webpanel\SettingmembershipController::class, 'status'])->where(['id' => '[0-9]+']);
        });
    });
});
