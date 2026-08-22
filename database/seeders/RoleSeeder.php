<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Créer les permissions
        $permissions = [
            'gerer-utilisateurs',
            'gerer-patients',
            'gerer-dossiers',
            'gerer-consultations',
            'gerer-rendezvous',
            'consulter-audit',
            'archiver-dossiers',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // 2. Rôle Admin — gestion du système uniquement.
        // Ni actes cliniques (gerer-consultations) ni planification de
        // rendez-vous (gerer-rendezvous) : ces tâches sont réservées aux
        // médecins et au secrétariat, pas à l'administration système.
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions([
            'gerer-utilisateurs',
            'gerer-patients',
            'consulter-audit',
            'archiver-dossiers',
        ]);

        // 3. Rôle Médecin — saisie clinique + gestion de ses rendez-vous
        $medecin = Role::firstOrCreate(['name' => 'medecin']);
        $medecin->syncPermissions([
            'gerer-patients',
            'gerer-dossiers',
            'gerer-consultations',
            'gerer-rendezvous',
        ]);

        // 4. Rôle Secrétariat — accueil, dossiers administratifs, planning
        $secretariat = Role::firstOrCreate(['name' => 'secretariat']);
        $secretariat->syncPermissions([
            'gerer-patients',
            'gerer-rendezvous',
        ]);

        // 5. Compte admin par défaut
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@khar-yalla.sn'],
            [
                'name' => 'Administrateur',
                'password' => bcrypt('password'),
            ]
        );
        $adminUser->syncRoles(['admin']);
    }
}