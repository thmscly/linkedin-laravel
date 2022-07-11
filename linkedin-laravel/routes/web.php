<?php

use App\Http\Controllers\NoteController;
use App\Http\Controllers\TrashedNoteController;
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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

//"Resource Controllers" will create all required resource routes for CRUD: create with sail artisan make:controller NoteController --resource. middleare auth makes user sign in to access page
Route::resource('/notes', NoteController::class)->middleware('auth');

Route::prefix('/trashed')->name('trashed.')->middleware('auth')->group(function () {
    Route::get('/', [TrashedNoteController::class, 'index'])->name('index');
    Route::get('/{note}', [TrashedNoteController::class, 'show'])->name('show')->withTrashed();
    Route::put('/{note}', [TrashedNoteController::class, 'update'])->name('update')->withTrashed();
    Route::delete('/{note}', [TrashedNoteController::class, 'destroy'])->name('destroy')->withTrashed();

});

require __DIR__ . '/auth.php';
