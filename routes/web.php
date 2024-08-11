<?php

use App\Models\Form;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JawabanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QuestionsController;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/detail/{template}', [HomeController::class, 'show'])->name('showTemplate');



Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/menuform', [DashboardController::class, 'mainPage']);
    Route::get('/dashboard/menuform/{template}', [DashboardController::class, 'templateForm'])->name('formDetail');;
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/dashboard/template', TemplateController::class);
    Route::resource('/dashboard/menuform/form', FormController::class);
    Route::resource('/detail/answer', JawabanController::class);
    Route::get('/dashboard/menuform/form/questionCreate/{form}', [QuestionController::class, 'makeQuetion']);
    
    
});

require __DIR__.'/auth.php';

