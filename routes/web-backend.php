<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Webpanel as Webpanel;
use App\Http\Controllers\Functions as Functions;
use App\Http\Controllers\Webpanel\AuthController;

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
            Route::get('reserve_history/edit/{id}', [Webpanel\Reserve_history_controller::class, 'edit'])->name('reserve_history.edit');
            Route::post('reserve_history/edit/{id}', [Webpanel\Reserve_history_controller::class, 'update'])->name('reserve_history.update');
            Route::delete('/reserve_history/destroy/{id}', [Webpanel\Reserve_history_controller::class, 'destroy'])->name('reserve_history.destroy')->where(['id' => '[0-9]+']);
            Route::get('/status/{id}', [Webpanel\Reserve_history_controller::class, 'status'])->where(['id' => '[0-9]+']);
        });


        Route::prefix('calendar')->group(function () {
            Route::get('/', [Webpanel\CalendarController::class, 'index'])->name('calendar.index');
            Route::get('/add', [Webpanel\CalendarController::class, 'add'])->name('calendar.add');
            Route::post('/add', [Webpanel\CalendarController::class, 'insert'])->name('calendar.insert');
            Route::get('/edit/{id}', [Webpanel\CalendarController::class, 'edit'])->where(['id' => '[0-9]+'])->name('calendar.edit');
            Route::post('/edit/{id}', [Webpanel\CalendarController::class, 'update'])->where(['id' => '[0-9]+'])->name('calendar.update');
            Route::get('/destroy/{id}', [Webpanel\CalendarController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('calendar.destroy');
            Route::get('/status/{id}', [Webpanel\CalendarController::class, 'status'])->where(['id' => '[0-9]+']);
        });

        Route::prefix('ordinary_customer')->group(function () {
            Route::get('/', [Webpanel\Ordinary_customerController::class, 'index'])->name('ordinary_customer.index');
            Route::get('/add', [Webpanel\Ordinary_customerController::class, 'add'])->name('ordinary_customer.add');
            Route::post('/add', [Webpanel\Ordinary_customerController::class, 'insert'])->name('ordinary_customer.insert');
            Route::get('/edit/{id}', [Webpanel\Ordinary_customerController::class, 'edit'])->where(['id' => '[0-9]+'])->name('ordinary_customer.edit');
            Route::post('/edit/{id}', [Webpanel\Ordinary_customerController::class, 'update'])->where(['id' => '[0-9]+'])->name('ordinary_customer.update');
            Route::delete('/destroy/{id}', [Webpanel\Ordinary_customerController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('ordinary_customer.destroy');
            Route::get('/status/{id}', [Webpanel\Ordinary_customerController::class, 'status'])->where(['id' => '[0-9]+']);
        });

        Route::prefix('organization_customer')->group(function () {
            Route::get('/', [Webpanel\organization_customerController::class, 'index'])->name('organization_customer.index');
            Route::get('/add', [Webpanel\organization_customerController::class, 'add'])->name('organization_customer.add');
            Route::post('/add', [Webpanel\organization_customerController::class, 'insert'])->name('organization_customer.insert');
            Route::get('/edit/{id}', [Webpanel\organization_customerController::class, 'edit'])->where(['id' => '[0-9]+'])->name('organization_customer.edit');
            Route::post('/edit/{id}', [Webpanel\Organization_customerController::class, 'update'])->where(['id' => '[0-9]+'])->name('organization_customer.update');
            Route::delete('/destroy/{id}', [Webpanel\Organization_customerController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('organization_customer.destroy');
            Route::get('/status/{id}', [Webpanel\organization_customerController::class, 'status'])->where(['id' => '[0-9]+']);
        });

        Route::prefix('agent_customer')->group(function () {
            Route::get('/', [Webpanel\Agent_customerController::class, 'index'])->name('agent_customer.index');
            Route::get('/add', [Webpanel\Agent_customerController::class, 'add'])->name('agent_customer.add');
            Route::post('/add', [Webpanel\Agent_customerController::class, 'insert'])->name('agent_customer.insert');
            Route::get('/edit/{id}', [Webpanel\Agent_customerController::class, 'edit'])->where(['id' => '[0-9]+'])->name('agent_customer.edit');
            Route::post('/edit/{id}', [Webpanel\Agent_customerController::class, 'update'])->where(['id' => '[0-9]+'])->name('agent_customer.update');
            Route::delete('/destroy/{id}', [Webpanel\Agent_customerController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('agent_customer.destroy');
            Route::get('/status/{id}', [Webpanel\Agent_customerController::class, 'status'])->where(['id' => '[0-9]+']);
        });
        Route::prefix('data_equipment')->group(function () {
            Route::get('/', [Webpanel\Data_equipmentController::class, 'index'])->name('data_equipment.index');
            Route::get('/add', [Webpanel\Data_equipmentController::class, 'add'])->name('data_equipment.add');
            Route::post('/add', [Webpanel\Data_equipmentController::class, 'insert'])->name('data_equipment.insert');
            Route::get('/edit/{id}', [Webpanel\Data_equipmentController::class, 'edit'])->where(['id' => '[0-9]+'])->name('data_equipment.edit');
            Route::post('/edit/{id}', [Webpanel\Data_equipmentController::class, 'update'])->where(['id' => '[0-9]+'])->name('data_equipment.update');
            Route::delete('/destroy/{id}', [Webpanel\Data_equipmentController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('data_equipment.destroy');
            Route::get('/status/{id}', [Webpanel\Data_equipmentController::class, 'status'])->where(['id' => '[0-9]+']);
        });

        Route::prefix('promotion')->group(function () {
            Route::get('/', [Webpanel\promotionController::class, 'index'])->name('promotion.index');
            Route::get('/add', [Webpanel\promotionController::class, 'add'])->name('promotion.add');
            Route::post('/add', [Webpanel\promotionController::class, 'insert'])->name('promotion.insert');
            Route::get('/edit/{id}', [Webpanel\promotionController::class, 'edit'])->where(['id' => '[0-9]+'])->name('promotion.edit');
            Route::post('/edit/{id}', [Webpanel\promotionController::class, 'update'])->where(['id' => '[0-9]+'])->name('promotion.update');
            Route::delete('/destroy/{id}', [Webpanel\promotionController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('promotion.destroy');
            Route::get('/status/{id}', [Webpanel\promotionController::class, 'status'])->where(['id' => '[0-9]+']);
        });

        Route::prefix('data_contact')->group(function () {
            Route::get('/', [Webpanel\Data_contactController::class, 'index'])->name('data_contact.index');
            Route::get('/add', [Webpanel\Data_contactController::class, 'add'])->name('data_contact.add');
            Route::post('/add', [Webpanel\Data_contactController::class, 'insert'])->name('data_contact.insert');
            Route::get('/edit/{id}', [Webpanel\Data_contactController::class, 'edit'])->where(['id' => '[0-9]+'])->name('data_contact.edit');
            Route::post('/edit/{id}', [Webpanel\Data_contactController::class, 'update'])->where(['id' => '[0-9]+'])->name('data_contact.update');
            Route::delete('/destroy/{id}', [Webpanel\Data_contactController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('data_contact.destroy');
            Route::get('/status/{id}', [Webpanel\Data_contactController::class, 'status'])->where(['id' => '[0-9]+']);
        });

        Route::prefix('settingrefund')->group(function () {
            Route::get('/', [Webpanel\SettingrefundController::class, 'index'])->name('settingrefund.index');
            Route::get('/add', [Webpanel\SettingrefundController::class, 'add'])->name('settingrefund.add');
            Route::post('/add', [Webpanel\SettingrefundController::class, 'insert'])->name('settingrefund.insert');
            Route::get('/edit/{id}', [Webpanel\SettingrefundController::class, 'edit'])->where(['id' => '[0-9]+'])->name('settingrefund.edit');
            Route::post('/edit/{id}', [Webpanel\SettingrefundController::class, 'update'])->where(['id' => '[0-9]+']);
            Route::get('/destroy/{id}', [Webpanel\SettingrefundController::class, 'destroy'])->where(['id' => '[0-9]+']);
            Route::get('/status/{id}', [Webpanel\SettingrefundController::class, 'status'])->where(['id' => '[0-9]+']);
        });

        Route::prefix('settingqrcode')->group(function () {
            Route::get('/', [Webpanel\SettingqrcodeController::class, 'index'])->name('settingqrcode.index');
            Route::get('/add', [Webpanel\SettingqrcodeController::class, 'add'])->name('settingqrcode.add');
            Route::post('/add', [Webpanel\SettingqrcodeController::class, 'insert'])->name('settingqrcode.insert');
            Route::get('/edit/{id}', [Webpanel\SettingqrcodeController::class, 'edit'])->where(['id' => '[0-9]+'])->name('settingqrcode.edit');
            Route::post('/edit/{id}', [Webpanel\SettingqrcodeController::class, 'update'])->where(['id' => '[0-9]+']);
            Route::get('/destroy/{id}', [Webpanel\SettingqrcodeController::class, 'destroy'])->where(['id' => '[0-9]+']);
            Route::get('/status/{id}', [Webpanel\SettingqrcodeController::class, 'status'])->where(['id' => '[0-9]+']);
        });

        Route::prefix('settingmembership')->group(function () {
            Route::get('/', [Webpanel\SettingmembershipController::class, 'index'])->name('settingmembership.index');
            Route::get('/add', [Webpanel\SettingmembershipController::class, 'add'])->name('settingmembership.add');
            Route::post('/add', [Webpanel\SettingmembershipController::class, 'insert'])->name('settingmembership.insert');
            Route::get('/edit/{id}', [Webpanel\SettingmembershipController::class, 'edit'])->where(['id' => '[0-9]+'])->name('settingmembership.edit');
            Route::post('/edit/{id}', [Webpanel\SettingmembershipController::class, 'update'])->where(['id' => '[0-9]+']);
            Route::get('/destroy/{id}', [Webpanel\SettingmembershipController::class, 'destroy'])->where(['id' => '[0-9]+']);
            Route::get('/status/{id}', [Webpanel\SettingmembershipController::class, 'status'])->where(['id' => '[0-9]+']);
        });

        Route::prefix('settingadmin')->group(function () {
            Route::get('/', [Webpanel\SettingadminController::class, 'index'])->name('settingadmin.index');
            Route::get('/add', [Webpanel\SettingadminController::class, 'add'])->name('settingadmin.add');
            Route::post('/add', [Webpanel\SettingadminController::class, 'insert'])->name('settingadmin.insert');
            Route::get('/edit/{id}', [Webpanel\SettingadminController::class, 'edit'])->where(['id' => '[0-9]+'])->name('settingadmin.edit');
            Route::post('/edit/{id}', [Webpanel\SettingadminController::class, 'update'])->where(['id' => '[0-9]+'])->name('settingadmin.update');
            Route::delete('/destroy/{id}', [Webpanel\SettingadminController::class, 'destroy'])->where(['id' => '[0-9]+']);
            Route::get('/status/{id}', [Webpanel\SettingadminController::class, 'status'])->where(['id' => '[0-9]+']);
        });

        Route::prefix('settingarea')->group(function () {
            Route::get('/', [Webpanel\DataAreaController::class, 'index'])->name('dataarea.index');
            Route::get('/add', [Webpanel\DataAreaController::class, 'add'])->name('dataarea.add');
            Route::post('/add', [Webpanel\DataAreaController::class, 'insert'])->name('dataarea.insert');
            Route::get('/edit/{id}', [Webpanel\DataAreaController::class, 'edit'])->where(['id' => '[0-9]+'])->name('dataarea.edit');
            Route::post('/edit/{id}', [Webpanel\DataAreaController::class, 'update'])->where(['id' => '[0-9]+'])->name('dataarea.update');
            Route::delete('/destroy/{id}', [Webpanel\DataAreaController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('dataarea.destroy');
            Route::get('/status/{id}', [Webpanel\DataAreaController::class, 'status'])->where(['id' => '[0-9]+']);
        });
    });
});
