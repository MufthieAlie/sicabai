<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiagnosisHistoryController;
use App\Http\Controllers\KnowledgeBaseController;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/diagnosis', [DiagnosisController::class, 'index'])->name('diagnosis.index');
    Route::post('/diagnosis/ekstrak', [DiagnosisController::class, 'ekstrak'])->name('diagnosis.ekstrak');
    Route::post('/diagnosis/proses', [DiagnosisController::class, 'proses'])->name('diagnosis.proses');
    Route::get('/diagnosis/history', [DiagnosisHistoryController::class, 'mine'])->name('diagnosis.history');

    Route::middleware('role:admin,pakar')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('dashboard/history', [DiagnosisHistoryController::class, 'team'])->name('dashboard.history');
        Route::get('dashboard/knowledge/{resource}', [KnowledgeBaseController::class, 'index'])->name('dashboard.knowledge');
        Route::post('dashboard/knowledge/{resource}', [KnowledgeBaseController::class, 'store'])->name('dashboard.knowledge.store');
        Route::post('dashboard/knowledge/synonyms/group', [KnowledgeBaseController::class, 'storeSynonymGroup'])->name('dashboard.knowledge.synonyms.store-group');
        Route::put('dashboard/knowledge/synonyms/group', [KnowledgeBaseController::class, 'updateSynonymGroup'])->name('dashboard.knowledge.synonyms.update-group');
        Route::delete('dashboard/knowledge/synonyms/group', [KnowledgeBaseController::class, 'destroySynonymGroup'])->name('dashboard.knowledge.synonyms.destroy-group');
        Route::put('dashboard/knowledge/{resource}/{id}', [KnowledgeBaseController::class, 'update'])->name('dashboard.knowledge.update');
        Route::delete('dashboard/knowledge/{resource}/{id}', [KnowledgeBaseController::class, 'destroy'])->name('dashboard.knowledge.destroy');
    });

    Route::middleware('role:admin')->group(function () {
        Route::get('dashboard/users', [AdminUserController::class, 'index'])->name('dashboard.users');
        Route::delete('dashboard/users/{user}', [AdminUserController::class, 'destroy'])->name('dashboard.users.destroy');
    });
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
