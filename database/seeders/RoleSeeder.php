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

        // 2. Rôle Admin — gestion du système, PAS d'acte clinique
        // (traçabilité : un diagnostic/traitement doit être attribuable à un soignant réel)
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions([
            'gerer-utilisateurs',
            'gerer-patients',      // peut corriger des données administratives d'un patient
            'gerer-rendezvous',    // peut réorganiser un planning en cas de besoin
            'consulter-audit',
            'archiver-dossiers',
        ]);
        // Volontairement PAS de 'gerer-consultations' ici.

        // 3. Rôle Médecin — seul rôle habilité à la saisie clinique
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