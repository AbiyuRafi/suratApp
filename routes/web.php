<?php

use App\Http\Controllers\LetterController;
use App\Http\Controllers\LetterTypesController;
use App\Http\Controllers\ResultController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['IsGuest'])->group(function () {
    Route::get('/', function () {
        return view('login');
    })->name('login');  
    Route::post('/login', [UserController::class, 'loginAuth'])->name('login.auth');
});



Route::get('/error-permission', function () {
    return view('error.permission');
})->name('error.permission');

Route::middleware(['IsLogin'])->group(function () {
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/home', function () {
        return view('home');
    })->name('home.page');
});
Route::get('/home', [LetterController::class, 'page'])->name('home');

Route::middleware(['IsLogin', 'IsStaff'])->group(function () {
Route::prefix('/staff')->name('staff.')->group(function (){
    Route::get('/index', [UserController::class, 'index'])->name('index');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/storeStaff', [UserController::class, 'storeStaff'])->name('storeStaff');
    Route::get('/{id}', [UserController::class, 'edit'])->name('edit');
    Route::patch('/{id}', [UserController::class, 'update'])->name('update');
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('delete');

});

Route::prefix('/guru')->name('guru.')->group(function (){
    Route::get('/indexGuru', [UserController::class, 'indexGuru'])->name('indexGuru');
    Route::get('/createGuru', [UserController::class, 'createGuru'])->name('createGuru');
    Route::post('/storeGuru', [UserController::class, 'storeGuru'])->name('storeGuru');
    Route::get('/{id}', [UserController::class, 'editGuru'])->name('editGuru');
    Route::patch('/{id}', [UserController::class, 'updateGuru'])->name('updateGuru');
    Route::delete('/{id}', [UserController::class, 'destroyGuru'])->name('deleteGuru');
});

Route::prefix('/klasifikasi')->name('klasifikasi.')->group(function (){
    Route::get('/index', [LetterTypesController::class, 'index'])->name('index');
    Route::get('/create', [LetterTypesController::class, 'create'])->name('create');
    Route::post('/store', [LetterTypesController::class, 'store'])->name('store');
    Route::get('/export', [LetterTypesController::class, 'export'])->name('export');
    Route::get('/{id}/edit', [LetterTypesController::class, 'edit'])->name('edit');
    Route::patch('/{id}', [LetterTypesController::class, 'update'])->name('update');
    Route::delete('/{id}', [LetterTypesController::class, 'destroy'])->name('delete');
    Route::get('/print/{id}/', [LetterTypesController::class, 'show'])->name('print');
    Route::get('/download/{id}', [LetterTypesController::class, 'downloadPDF'])->name('download');
});


Route::prefix('/letters')->name('letters.')->group(function() {
    Route::get('/index', [LetterController::class, 'index'])->name('index');
    Route::get('/create', [LetterController::class, 'create'])->name('create');
    Route::post('/store', [LetterController::class, 'store'])->name('store');
    Route::get('/{id}', [LetterController::class, 'edit'])->name('edit');
    Route::patch('/{id}', [LetterController::class, 'update'])->name('update');
    Route::delete('/{id}', [LetterController::class, 'destroy'])->name('delete');
});
});


Route::middleware(['IsLogin', 'IsGuru'])->group(function () {
    Route::prefix('/user')->name('user.')->group(function() {

    Route::get('/index', [LetterController::class, 'index'])->name('index');
});
});
