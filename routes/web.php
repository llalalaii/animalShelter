<?php

use App\Http\Controllers\AdopterController;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DiseaseController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\InjuryController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\RescuerController;
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

// These are the routes for authentications: login and logout
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'login_submit'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/contact', [ContactController::class, 'contact'])->name('contact.index');

// These route shows the main page where we showcase the animals without any sickness (rehabilitated) and are ready for adoption.
Route::get('/', [MainController::class, 'home'])->name('home');
Route::name('home.adoptable')->prefix('adoptable')->group(function () {
    Route::get('/', [MainController::class, 'adoptable']);
    Route::get('/{name}', [MainController::class, 'adoptableSearch'])->name('search');
});

// In these type of application i like to use "resource" because it gives a nice template to start for CRUDs which in this case has a lot of them.
Route::resource('animals', AnimalController::class);
Route::resource('rescuers', RescuerController::class);
Route::resource('adopters', AdopterController::class);

// I wrapped the routes that needed to be under the protection of auth middleware so that unauthorized users will not be able to access them.
Route::middleware(['web', 'auth'])->group(function () {
    Route::resource('employees', EmployeeController::class);
    Route::resource('diseases', DiseaseController::class);
    Route::resource('injuries', InjuryController::class);

    // These routes are added because they are outside the resource template.
    Route::name('animals.')->prefix('animals')->group(function () {
        Route::post('/upload', [AnimalController::class, 'uploadPhotos'])->name('upload');
        Route::delete('/remove/photo/{id}', [AnimalController::class, 'removePhotos'])->name('remove');
        Route::post('/attachDetachSickness/', [AnimalController::class, 'attachDetachSickness'])->name('attachDetachSickness');
    });
    Route::post('/rescuers/attachDetach/', [RescuerController::class, 'attachDetach'])->name('rescuers.attachDetach');
    Route::post('/adopters/attachDetach/', [AdopterController::class, 'attachDetach'])->name('adopters.attachDetach');
});
