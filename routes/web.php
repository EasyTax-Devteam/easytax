<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', [App\Http\Controllers\Web\WebsiteController::class, 'index'])->name('w.index');
Route::get('/email', [App\Http\Controllers\Web\WebsiteController::class, 'email']);
Route::get('/about', [App\Http\Controllers\Web\WebsiteController::class, 'about'])->name('w.about');
Route::group(['prefix' => 'file/step'], function(){

    Route::get('/init/{id}', [App\Http\Controllers\Web\FilingController::class, 'file_return'])->name('w.f.return');
    /** nill */
    Route::get('/nill', [App\Http\Controllers\Web\FilingController::class, 'file_Nill'])->name('w.f.nill');
    Route::post('/post/nill', [App\Http\Controllers\Web\FilingController::class, 'post_Nill'])->name('w.f.post.nill');
    /** freelance */
    Route::get('/freelance', [App\Http\Controllers\Web\FilingController::class, 'file_Freelance'])->name('w.f.freelance');
    Route::post('/post/freelance', [App\Http\Controllers\Web\FilingController::class, 'post_Freelance'])->name('w.f.post.freelance');
    /** employee */
    Route::get('/employee', [App\Http\Controllers\Web\FilingController::class, 'file_Employee'])->name('w.f.employee');
    Route::post('/post/employee', [App\Http\Controllers\Web\FilingController::class, 'post_Employee'])->name('w.f.post.employee');
    /** employee */
    Route::get('/company', [App\Http\Controllers\Web\FilingController::class, 'file_Company'])->name('w.f.company');
    Route::post('/post/company', [App\Http\Controllers\Web\FilingController::class, 'post_Company'])->name('w.f.post.company');
    
    /** payment section */
    Route::get('/pay/form', [App\Http\Controllers\Web\WebsiteController::class, 'payform'])->name('w.f.payform');
    Route::post('/payment', [App\Http\Controllers\Web\WebsiteController::class, 'post_Pay'])->name('w.f.payment');
});

Route::group(['prefix' => 'callbacks'], function(){
    Route::post('/pay/status', [App\Http\Controllers\Web\WebsiteController::class, 'checkStatus'])->name('w.f.checkStatus');
    Route::any('/payment', [App\Http\Controllers\Web\WebsiteController::class, 'callback'])->name('mpesa.callback');
});

/** user */
Route::group(['prefix' => 'users'], function(){
    Route::get('/home', [App\Http\Controllers\Web\UserController::class, 'orders'])->name('w.u.orders');
    /** user logout */
    Route::get('/access', [App\Http\Controllers\Web\UserController::class, 'login'])->name('w.u.login');
    Route::post('/post/access', [App\Http\Controllers\Web\UserController::class, 'post_login'])->name('w.u.post_login');
    Route::get('/logout/app', [App\Http\Controllers\Web\UserController::class, 'logout'])->name('w.u.logout');
});

Route::group(['prefix' => 'easy/admin'], function(){
    Route::get('/', [App\Http\Controllers\User\UserController::class, 'index'])->name('e.tax.index');
    Route::group(['prefix' => 'users'], function(){
        Route::get('/', [App\Http\Controllers\User\UserController::class, 'users'])->name('e.tax.users');
        Route::post('/add', [App\Http\Controllers\User\UserController::class, 'add_user'])->name('e.tax.add.user');
        Route::get('/view/{id}', [App\Http\Controllers\User\UserController::class, 'view_user'])->name('e.tax.view.user');
        Route::post('/update', [App\Http\Controllers\User\UserController::class, 'update_user'])->name('e.tax.update.user');
        Route::get('/enable/{id}', [App\Http\Controllers\User\UserController::class, 'enable_user'])->name('e.tax.enable.user');
        Route::get('/disable/{id}', [App\Http\Controllers\User\UserController::class,'disable_user'])->name('e.tax.disable.user');
    });

    Route::group(['prefix' => 'orders'], function(){
        Route::get('/', [App\Http\Controllers\User\OrderController::class, 'orders'])->name('e.tax.orders');
        Route::get('/details/{id}', [App\Http\Controllers\User\OrderController::class, 'order'])->name('e.tax.order');
    });

    Route::group(['prefix' => 'services'], function(){
        Route::get('/', [App\Http\Controllers\User\ServiceController::class, 'services'])->name('e.tax.services');
        Route::post('/add', [App\Http\Controllers\User\ServiceController::class, 'add_service'])->name('e.tax.add.service');
        Route::get('/enable/{id}', [App\Http\Controllers\User\ServiceController::class, 'enable'])->name('e.tax.enable.svc');
        Route::get('/disable/{id}', [App\Http\Controllers\User\ServiceController::class,'disable'])->name('e.tax.disable.svc');
    });

    Route::group(['prefix' => 'payments'], function(){
        Route::get('/', [App\Http\Controllers\User\PaymentController::class, 'payments'])->name('e.tax.payments');
    });

    Route::group(['prefix' => 'settings'], function(){
        Route::get('/', [App\Http\Controllers\User\SettingController::class, 'settings'])->name('e.tax.settings');
        Route::post('/update', [App\Http\Controllers\User\SettingController::class, 'update'])->name('e.tax.update.settings');
    });

    Route::group(['prefix' => 'customers'], function(){
        Route::get('/', [App\Http\Controllers\User\CustomerController::class, 'customers'])->name('e.tax.customers');
    });

    Route::get('/log/out', [App\Http\Controllers\User\UserController::class, 'exit'])->name('app.exit');
});

Auth::routes(['except' => 'register']);

