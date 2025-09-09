<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LansiaController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\admin\UsersController;
use App\Http\Controllers\admin\SliderController;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome.index');

Auth::routes();
Route::middleware(['auth'])->group(
    function () {
        Route::name('dashboard.')->prefix('dashboard')->group(function () {
            Route::controller(DashboardController::class)->group(function () {
                Route::get('/', 'index')->name('index');
            });
        });

        // users
        Route::name('dashboard.')->prefix('dashboard')->group(function () {
            Route::controller(UsersController::class)->group(function () {
                Route::get('/users', 'index')->name('users.index');
                Route::get('/users/create', 'create')->name('users.create');
                Route::post('/users', 'store')->name('users.store');
                Route::get('/users/{id}/edit', 'edit')->name('users.edit');
                Route::put('/users/{id}', 'update')->name('users.update');
                Route::delete('/users/{id}', 'destroy')->name('users.destroy');
                Route::get('/users/polsek/{polres_id}', 'getPolsek')->name('users.polsek');
                Route::get('/users/{id}', 'show')->name('users.show');
            });

            Route::name('biodata.')->prefix('biodata')->group(function () {
                Route::controller(LansiaController::class)->group(function () {
                    Route::get('/get-desa/{kecamatan_id}', 'getDesa')->name('get-desa');
                    Route::get('/', 'index')->name('index');
                    Route::get('/datatable', 'datatable')->name('datatable');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/store', 'store')->name('store');
                    Route::get('/{id}/edit', 'edit')->name('edit');
                    Route::put('/{id}', 'update')->name('update');
                    Route::delete('/{id}', 'destroy')->name('destroy');
                    Route::get('/{id}', 'show')->name('show');
                    Route::post('/{id}/reject', 'reject')->name('reject');
                    Route::post('/{id}/approve', 'approve')->name('approve');
                });
            });

            Route::name('slider.')->prefix('slider')->group(function () {
                Route::controller(SliderController::class)->group(function () {
                    Route::get('/', 'index')->name('index');
                    Route::get('/create', 'create')->name('create');
                    Route::post('/store', 'store')->name('store');
                    Route::get('/{id}/edit', 'edit')->name('edit');
                    Route::put('/{id}', 'update')->name('update');
                    Route::delete('/{id}', 'destroy')->name('destroy');
                    Route::get('/{id}', 'show')->name('show');
                });
            });
        });
    }
);

Route::get('file/{path}/{filename}', function ($path, $filename) {
    $path = storage_path('app/public/' . $path . '/' . $filename);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
});