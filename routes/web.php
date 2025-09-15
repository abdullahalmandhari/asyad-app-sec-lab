<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\ComponentController;
use App\Http\Controllers\AuthDemoController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ProxyController;


Route::get('/', function () {
    return view('authdemo.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('authdemo')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
	Route::get('/shipments', [ShipmentController::class, 'index'])->name('shipments.index');
    Route::get('/shipments/{id}',  [ShipmentController::class, 'show_shipments'])->name('shipments.show');//->middleware(['auth', 'can:view,shipment']);
    Route::get('/shipment/export',[ShipmentController::class, 'export_csv'])->name('exportcsv');
    Route::get('/shipment/search', [ShipmentController::class, 'shipment_search'])->name('shipment_search');
    Route::get('shipment/{shipment}/delete',[ShipmentController::class, 'delete_shipment'])->name('delete_shipment');
    Route::get('/config', [ConfigController::class, 'trigger_exception'])->name('config');
    Route::get('/page', [ComponentController::class, 'load_components'])->name('load_components');
    Route::view('/upload', 'modules.upload')->name('modules.upload');;
    Route::post('/upload', [ModuleController::class, 'upload'])->name('upload');
    Route::get('/shipments/{id}/deliver', [ShipmentController::class, 'deliver'])   ->name('deliver');	
    Route::view('/proxy', 'proxy.form')->name('proxy.form');
    Route::get('/proxy/fetch', [ProxyController::class, 'fetchAvatar'])  ->name('fetch_avatar');


});

Route::middleware('guest')->group(function () {
   Route::view('/login', 'authdemo.login');
    Route::post('/login', [AuthDemoController::class, 'login'] )->name('authdemo.login');//->middleware('throttle:5,1');
});
	



#require __DIR__.'/auth.php';
