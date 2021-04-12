<?php

use App\Http\Controllers\Customers\CustomersController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Invoices\InvoicesController;
use App\Http\Controllers\Items\ItemsController;
use App\Http\Controllers\Users\UsersController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return redirect()->route('home');
})->name('index');;

Auth::routes();

Route::middleware(['auth'])->group(function () {
    
    Route::get('/home', [ HomeController::class, 'index' ])->name('home');
    
    Route::prefix('invoices')->name('invoices.')->group(function () {
        Route::get('create/json', [ InvoicesController::class, 'createJson' ])->name('createJson');
        Route::post('paginate',[ InvoicesController::class, 'paginate' ])->name('paginate');
    });
    Route::resource('invoices', Invoices\InvoicesController::class );
    
    Route::prefix('items')->name('items.')->group(function () {
        Route::post('uploadFile',[ ItemsController::class, 'uploadFile' ])->name('uploadFile');
        Route::post('paginate',[ ItemsController::class, 'paginate' ])->name('paginate');
        Route::get('json/{id}', [ ItemsController::class, 'json' ])->name('json');

    });
    Route::resource('items', Items\Itemscontroller::class );

    Route::prefix('customers')->name('customers.')->group(function () {
        Route::post('paginate',[ CustomersController::class, 'paginate' ])->name('paginate');
        Route::get('json/{id}', [ CustomersController::class, 'json' ])->name('json');

    });
    Route::resource('customers', Customers\CustomersController::class );

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/',[ UsersController::class, 'index' ])->name('index');
        Route::post('paginate',[ UsersController::class, 'paginate' ])->name('paginate');
        Route::put('disable-account/{id}',[UsersController::class, 'disableAccount' ])->name('disableAccount');
        Route::put('enable-account/{id}',[UsersController::class, 'enableAccount' ])->name('enableAccount');
        
    });

});