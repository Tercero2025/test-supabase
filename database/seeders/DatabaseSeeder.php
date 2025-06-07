<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Clients;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear roles
        $adminRole = Role::create(['name' => 'admin', 'description' => 'Administrator']);
        $clientRole = Role::create(['name' => 'cliente', 'description' => 'Client']);
        $guestRole = Role::create(['name' => 'invitado', 'description' => 'Guest']);

        // Crear permisos
        $permissions = [
            // Permisos para admin
            ['name' => 'create_client', 'endpoint' => '/api/clients', 'method' => 'POST'],
            ['name' => 'update_client', 'endpoint' => '/api/clients/{id}', 'method' => 'PUT'],
            ['name' => 'delete_client', 'endpoint' => '/api/clients/{id}', 'method' => 'DELETE'],
            ['name' => 'view_all_clients', 'endpoint' => '/api/clients', 'method' => 'GET'],

            // Permisos para cliente
            ['name' => 'view_own_profile', 'endpoint' => '/api/clients/{id}', 'method' => 'GET'],
            ['name' => 'update_own_profile', 'endpoint' => '/api/clients/{id}', 'method' => 'PUT'],

            // Permisos para invitado
            ['name' => 'view_public_info', 'endpoint' => '/api/public/*', 'method' => 'GET'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        // Asignar permisos a roles
        $adminRole->permissions()->attach(Permission::all());
        $clientRole->permissions()->attach(
            Permission::whereIn('name', ['view_own_profile', 'update_own_profile'])->get()
        );
        $guestRole->permissions()->attach(
            Permission::where('name', 'view_public_info')->get()
        );

        $users = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'remember_token' => Str::random(10),
                'is_superadmin' => true,
                'role_id' => null
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'remember_token' => Str::random(10),
                'is_superadmin' => false,
                'role_id' => $adminRole->id
            ],
            [
                'name' => 'Bob Johnson',
                'email' => 'bob@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'remember_token' => Str::random(10),
                'is_superadmin' => false,
                'role_id' => $clientRole->id
            ],
            [
                'name' => 'Alice Brown',
                'email' => 'alice@example.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'remember_token' => Str::random(10),
                'is_superadmin' => false,
                'role_id' => $clientRole->id
            ],
        ];

        foreach ($users as $userData) {
            $user = User::create($userData);

            // Si no es superadmin ni admin, asignar rol de cliente
            if (!$userData['is_superadmin'] && $userData['role_id'] !== $adminRole->id) {
                $user->role_id = $clientRole->id;
                $user->save();
            }

            Clients::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'fullname' => $user->name . ' Company',
                'cuit' => rand(20000000000, 29999999999),
                'address' => fake()->address(),
                'city' => fake()->city(),
                'state' => fake()->state(),
                'country' => fake()->country(),
            ]);
        }
    }
}
