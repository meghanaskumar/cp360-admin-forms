<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicFormController;
use App\Http\Controllers\Admin\FormController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/admin/forms', FormController::class);
});

Route::get('forms', [PublicFormController::class, 'index'])->name('public.forms.index');
Route::get('forms/{form}', [PublicFormController::class, 'show'])->name('public.forms.show');
Route::post('forms/{form}/submit', [PublicFormController::class, 'submit'])->name('public.forms.submit');

require __DIR__ . '/auth.php';
