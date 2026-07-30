<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\RendezVousController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuditController;

Route::get('/', function () {
    return redirect()->route(auth()->check() ? 'dashboard' : 'login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('patients/{patient}/toggle-archive', [PatientController::class, 'toggleArchive'])->name('patients.toggle-archive');
Route::get('audit', [AuditController::class, 'index'])->name('audit.index');

Route::middleware('auth')->group(function () {
    Route::resource('patients', PatientController::class);

    Route::get('dossiers/{dossier}/consultations/create', [ConsultationController::class, 'create'])->name('consultations.create');
    Route::post('dossiers/{dossier}/consultations', [ConsultationController::class, 'store'])->name('consultations.store');
    Route::get('consultations/{consultation}', [ConsultationController::class, 'show'])->name('consultations.show');
    Route::get('consultations/{consultation}/edit', [ConsultationController::class, 'edit'])->name('consultations.edit');
    Route::put('consultations/{consultation}', [ConsultationController::class, 'update'])->name('consultations.update');
    Route::delete('consultations/{consultation}', [ConsultationController::class, 'destroy'])->name('consultations.destroy');

    Route::get('rendezvous', [RendezVousController::class, 'index'])->name('rendezvous.index');
    Route::get('patients/{patient}/rendezvous/create', [RendezVousController::class, 'create'])->name('rendezvous.create');
    Route::post('patients/{patient}/rendezvous', [RendezVousController::class, 'store'])->name('rendezvous.store');
    Route::put('rendezvous/{rendezvous}', [RendezVousController::class, 'update'])->name('rendezvous.update');
    Route::delete('rendezvous/{rendezvous}', [RendezVousController::class, 'destroy'])->name('rendezvous.destroy');

    Route::resource('users', UserController::class)->except(['show']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';