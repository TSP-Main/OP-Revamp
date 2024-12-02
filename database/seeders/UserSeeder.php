<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function __construct()
    {
        $this->quoteStatus = config('constants.QUOTE_STATUS');
        $this->currencyTypes = config('constants.CURRENCY_TYPES');
        $this->currencies = config('constants.CURRENCIES');
        $this->curFormatDate = Carbon::now()->format('Y-m-d');
    }

    public function run(): void
    {
        // Create Super Admin user with profile and address
        $superAdmin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@admin.com',
            'password' => Hash::make('password'),
            'created_by'   => 1
        ])->assignRole('super_admin');

        $superAdminProfile = UserProfile::create([
            'user_id' => $superAdmin->id,
            'speciality' => 'Super Admin',
            'phone' => '1234567890',
            'gender' => 'male',
            'date_of_birth' => '1980-01-01',
            'short_bio' => 'all about super admin'
        ]);

        $superAdminAddress = UserAddress::create([
            'user_id' => $superAdmin->id,
            'address' => '123 Admin Street',
            'apartment' => 'green aid',
            'city' => 'Admin City',
            'state' => 'Admin City',
            'country' => 'england',
            'zip_code' => '12345',
        ]);

        // Create Dispensary user with profile and address
        $dispensary = User::create([
            'name' => 'Dispensary User',
            'email' => 'dispensary@gmail.com',
            'password' => Hash::make('password'),
            'created_by'   => 1
        ])->assignRole('dispensary');

        $dispensaryProfile = UserProfile::create([
            'user_id' => $dispensary->id,
            'speciality' => 'Dispensary',
            'phone' => '0987654321',
            'short_bio' => 'all about dispensary'
        ]);

        $dispensaryAddress = UserAddress::create([
            'user_id' => $dispensary->id,
            'address' => '123 Admin Street',
            'apartment' => 'green aid',
            'city' => 'Dispensary City',
            'state' => 'Dispensary City',
            'country' => 'england',
            'zip_code' => '12345',
        ]);

        // Create Doctor user with profile and address
        $doctor = User::create([
            'name' => 'Doctor User',
            'email' => 'doctor@gmail.com',
            'password' => Hash::make('password'),
            'created_by'   => 1
        ])->assignRole('doctor');

        $doctorProfile = UserProfile::create([
            'user_id' => $doctor->id,
            'speciality' => 'Doctor',
            'phone' => '1122334455',
            'gender' => 'male',
            'date_of_birth' => '1985-03-03',
            'short_bio' => 'all about doctor'
        ]);

        $doctorAddress = UserAddress::create([
            'user_id' => $doctor->id,
            'address' => '123 Admin Street',
            'apartment' => 'green aid',
            'city' => 'Doctor City',
            'state' => 'Doctor City',
            'country' => 'england',
            'zip_code' => '12345',
        ]);

        // Create Normal User with profile and address
        $user = User::create([
            'name' => 'Normal User',
            'email' => 'user@user.com',
            'password' => Hash::make('password'),
        ])->assignRole('user');

        $userProfile = UserProfile::create([
            'user_id' => $user->id,
            'speciality' => 'User',
            'phone' => '5566778899',
            'gender' => 'male',
            'date_of_birth' => '2000-10-10',
            'short_bio' => 'all about user'
        ]);

        $userAddress = UserAddress::create([
            'user_id' => $user->id,
            'address' => '123 Admin Street',
            'apartment' => 'green aid',
            'city' => 'User City',
            'state' => 'User City',
            'country' => 'england',
            'zip_code' => '12345',
        ]);

        $pharmacy = User::create([
            'name' => 'Pharmacy User',
            'email' => 'pharmacy@gmail.com',
            'password' => Hash::make('password'),
            'created_by'   => 1
        ])->assignRole('pharmacy'); // Assign the 'pharmacy' role

        $pharmacyProfile = UserProfile::create([
            'user_id' => $pharmacy->id,
            'speciality' => 'Pharmacy',
            'phone' => '2233445566',
            'short_bio' => 'all about pharmacy'
        ]);

        $pharmacyAddress = UserAddress::create([
            'user_id' => $pharmacy->id,
            'address' => '123 Admin Street',
            'apartment' => 'green aid',
            'city' => 'Pharmacy City',
            'state' => 'Pharmacy City',
            'country' => 'england',
            'zip_code' => '12345',
        ]);
    }
}
