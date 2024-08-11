<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;


class Users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected $quoteStatus;
    protected $currencies;
    protected $curFormatDate;
    protected $currencyTypes;

    public function __construct()
    {
        $this->quoteStatus = config('constants.QUOTE_STATUS');
        $this->currencyTypes = config('constants.CURRENCY_TYPES');
        $this->currencies = config('constants.CURRENCIES');
        $this->curFormatDate = Carbon::now()->format('Y-m-d');
    }

    public function run()
    {
        // Create an Super Admin
        User::factory()->create([
            'name'       => 'Web Admin',
            'email'      => 'Phillip@onlinepharmacy-4u.co.uk',
            'password'   => Hash::make('Admin1234$#@!'),
            'role'       => 'Super Admin',
            'gender'       => 'male',
            'status'     => '1',
            'created_by' => '1',
        ]);

        // Create a Dispensaryz
        User::factory()->create([
            'name'         => 'Dispensary',
            'email'        => 'dispensary@gmail.com',
            'phone'        => '+923394030',
            'gender'       => 'male',
            'address'      => 'gernal texi stand.',
            'password'     => Hash::make('admin@123'),
            'role'         => 'Dispensary',
            'status'       => '1',
            'created_by'   => '2'
        ]);

        // Create a Doctor
        User::factory()->create([
            'name'         => 'Doctor',
            'email'        => 'doctor@gmail.com',
            'phone'        => '+923394030',
            'gender'       => 'male',
            'address'      => 'gernal texi stand.',
            'password'     => Hash::make('admin@123'),
            'role'         => 'Doctor',
            'status'       => '1',
            'created_by'   => '3'
        ]);

        // Create a User
        User::factory()->create([
            'name'      => 'Web User',
            'email'     => 'webuser@gmail.com',
            'dob'       => '02/16/2024',
            'phone'     => '+923394030',
            'gender'    => 'male',
            'address'   => 'gernal texi stand.',
            'password'  => Hash::make('admin@123'),
            'role'      => 'User',
            'status'    => '1',
            'created_by' => '1'
        ]);
    }
}
