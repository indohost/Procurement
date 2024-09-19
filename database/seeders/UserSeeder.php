<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //  TRUNCATE the users, roles and permissions table, comment this code if doesn't needed
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Role::truncate();
        Permission::truncate();
        Schema::enableForeignKeyConstraints();

        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $superAdmin = Role::create([
            'name' => 'superadmin'
        ]);

        $admin = Role::create([
            'name' => 'admin'
        ]);

        $vendor = Role::create([
            'name' => 'vendor'
        ]);

        $buyer = Role::create([
            'name' => 'buyer'
        ]);

        $permissions = config('permission.list_roles.superadmin');
        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission
            ]);
        }

        // Create Users
        $users = [
            [
                'name' => 'Syarif',
                'email' => 'syarif@mail.dev',
                'password' => Hash::make('12341234'),
                'role' => $superAdmin,
                'permission' => $permissions
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@mail.dev',
                'password' => Hash::make('12341234'),
                'role' => $admin,
                'permission' => config('permission.list_roles.admin'),
            ],
            [
                'name' => 'Vendor 1',
                'email' => 'vendor1@mail.dev',
                'password' => Hash::make('12341234'),
                'role' => $vendor,
                'permission' => config('permission.list_roles.vendor'),
            ],
            [
                'name' => 'Buyer 1',
                'email' => 'buyer1@mail.dev',
                'password' => Hash::make('12341234'),
                'role' => $buyer,
                'permission' => config('permission.list_roles.buyer'),
            ],
        ];

        $idNewUserVendor = null;

        foreach ($users as $user) {
            $newUser = User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => $user['password'],
            ])->assignRole($user['role']);

            $newUser->givePermissionTo($user['permission']);
            $newUser->save();

            if ($user['email'] == 'vendor1@mail.dev') $idNewUserVendor = $newUser->id;

            sleep(1);
        }

        $requestVendor = [
            'name' => 'PT Syarif',
            'telephone' => '0819819301',
            'business_field' => 'Kesehatan dan Farmasi',
            'npwp' => '123456781234567',
            'address' => 'Alamat perusahaan',
            'website' => 'www.google.com',
            'description' => 'Perusahaan bergerak pada bidang kesehatan',
            'status' => config('general.vendor_status.accepted'),
            'user_id' => $idNewUserVendor,
        ];

        Vendor::create($requestVendor);

        $this->command->info('Create users by running the seeder successfully');
    }
}
