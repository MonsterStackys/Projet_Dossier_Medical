<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\RendezVousController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuditController;
use Illuminate\Support\Facades\Route;

// Modèles nécessaires pour les statistiques
use App\Models\Patient;
use App\Models\Consultation;
use App\Models\RendezVous;
use App\Models\User;

Route::get('/', function () {
    return redirect()->route(auth()->check() ? 'dashboard' : 'login');
});

// Groupe de routes nécessitant d'être authentifié
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard avec toutes les clés requises par votre vue Blade
    Route::get('/dashboard', function () {
        $stats = [
            'total_patients'        => Patient::count(),
            'dossiers_actifs'       => Patient::where('is_archived', false)->count(),
            'total_consultations'   => Consultation::count(),
            'consultations_mois'    => Consultation::whereMonth('created_at', now()->month)
                                                 ->whereYear('created_at', now()->year)
                                                 ->count(),
            'total_rendezvous'      => RendezVous::count(),
            'rendezvous_aujourdhui' => RendezVous::whereDate('date_rendez_vous', now()->today())->count(),
            'total_users'           => User::count(),
        ];

        // Récupère les 5 prochains rendez-vous à venir
        $prochainsRdv = RendezVous::with('patient')
            ->whereDate('date_rendez_vous', '>=', now()->today())
            ->orderBy('date_rendez_vous', 'asc')
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'prochainsRdv'));
    })->name('dashboard');

    // Sécurisation : Déplacement des routes patients et audit dans le middleware auth
    Route::get('patients/{patient}/toggle-archive', [PatientController::class, 'toggleArchive'])->name('patients.toggle-archive');
    Route::get('audit', [AuditController::class, 'index'])->name('audit.index');

    // Ressources et sous-routes
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

    // Routes du profil utilisateur (y compris la gestion de la photo)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // NOUVELLES ROUTES : Gestion de la photo de profil
    Route::post('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.photo.update');
    Route::delete('/profile/photo', [ProfileController::class, 'destroyPhoto'])->name('profile.photo.destroy');
});

require __DIR__.'/auth.php';