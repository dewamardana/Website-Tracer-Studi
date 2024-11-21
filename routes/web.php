<?php

use App\Models\Form;
use App\Http\Middleware\Admin;
use App\Http\Middleware\Dashboard;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JawabanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\userController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/detail/{kategori:slug}', [HomeController::class, 'show'])->name('showKategori');


Route::middleware([Dashboard::class])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/menutemplate', [DashboardController::class, 'mainPage']);
    Route::get('/dashboard/menutemplate/{kategori:slug}', [DashboardController::class, 'TemplatePage'])->name('templateDetail');
    Route::resource('/dashboard/kategori', KategoriController::class)->middleware(Admin::class);
    Route::resource('/dashboard/user', UserController::class)->middleware(Admin::class);
    Route::get('/dashboard/menutemplate/template/copy', [TemplateController::class, 'pilihTemplate'])->name('copyTemplate');
    Route::get('/dashboard/menutemplate/template/copy/{template:slug}', [TemplateController::class, 'copyTemplate']);
    Route::get('/dashboard/menutemplate/template/{id}/duplicate', [TemplateController::class, 'duplicates'])->name('duplicateTemplate');
    Route::get('/dashboard/menutemplate/template/{template:slug}/check', [TemplateController::class, 'checkAndRedirect'])->name('checkTemplate');
    Route::resource('/dashboard/menutemplate/template', TemplateController::class);
    Route::resource('/dashboard/form', FormController::class);
    Route::get('/dashboard/menutemplate/form/questionCreate/{form}', [QuestionController::class, 'makeQuetion']);
    
});


Route::middleware('auth')->group(function () {    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    Route::get('/detail/answer/{form:slug}', [JawabanController::class, 'showQuestion']);
    Route::resource('/detail/answer', JawabanController::class);
    Route::get('/detail/template/{template:slug}', [HomeController::class, 'form'])->name('showForm');
    
     
});

require __DIR__.'/auth.php';

