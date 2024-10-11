<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserProfile;
use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ImportsController extends Controller
{
    public function importUsersData(Request $request)
    {
        // Validate the incoming request for a CSV file
        $request->validate([
            'csv' => 'required|file|mimes:csv,txt',
        ]);

        if (($handle = fopen($request->file('csv'), 'r')) !== false) {
            fgetcsv($handle); // Skip the header row

            DB::transaction(function () use ($handle) {
                while (($data = fgetcsv($handle, 5000, ',')) !== false) {
                    // Replace "NULL" strings with actual null values
                    $data = array_map(function($value) {
                        return $value === 'NULL' ? null : $value;
                    }, $data);

                    // Validate and convert date format for DOB
                    $dateOfBirth = null;
                    if (!empty($data[5])) {
                        try {
                            // Change 'd-m-Y' to the actual format found in your CSV
                            $dateOfBirth = Carbon::createFromFormat('d-m-Y', $data[5])->format('Y-m-d');
                        } catch (InvalidFormatException $e) {
                            // Log the error or handle it accordingly
                            \Log::error("Invalid date format for DOB: {$data[5]} - Error: " . $e->getMessage());
                            // Optionally, set $dateOfBirth to null or a default value
                        }
                    }

                    // Check if the user with the same email already exists
                    $existingUser = User::where('email', $data[2])->first();

                    if ($existingUser) {
                        // Update existing user
                        $existingUser->update([
                            'name' => $data[1],
                            'email_verified_at' => $data[3],
                            'password' => bcrypt($data[6]), // Optionally update the password
                            'dob' => $dateOfBirth,
                            'gender' => $data[4],
                            'phone' => $data[9],
                            'address' => $data[10],
                            'id_document' => $data[11],
                            'apartment' => $data[12],
                            'country' => $data[15],
                            'zip_code' => $data[16],
                            'city' => $data[17],
                            'state' => $data[18],
                            'profile_status' => $data[25],
                            'consult_status' => $data[26],
                            'updated_at' => now(),
                        ]);
                        \Log::info("Updated existing user with email: {$data[2]}");
                    } else {
                        // Create a new user
                        User::create([
                            'name' => $data[1],
                            'email' => $data[2],
                            'email_verified_at' => $data[3],
                            'password' => bcrypt($data[6]),
                            'dob' => $dateOfBirth,
                            'gender' => $data[4],
                            'phone' => $data[9],
                            'address' => $data[10],
                            'id_document' => $data[11],
                            'apartment' => $data[12],
                            'country' => $data[15],
                            'zip_code' => $data[16],
                            'city' => $data[17],
                            'state' => $data[18],
                            'otp' => $data[19],
                            'reset_pswd_time' => $data[20],
                            'reset_pswd_attempt' => $data[21],
                            'role' => $data[22],
                            'user_pic' => $data[23],
                            'created_by' => $data[28],
                            'updated_by' => $data[29],
                            'remember_token' => $data[30],
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                        \Log::info("Created new user with email: {$data[2]}");
                    }
                }
            });

            fclose($handle);
        }

        return redirect()->back()->with('success', 'User data imported successfully!');
    }

    public function importOrdersData(Request $request)
    {
        if (($handle = fopen($request->file('csv'), 'r')) !== false) {
            // Skip the header
            $header = fgetcsv($handle, 5000, ',');

            // Define the correct columns that exist in your orders table
            $existingColumns = [
                'id', 'user_id', 'note', 'print', 'total_ammount', 'payment_id',
                'payment_status', 'hcp_remarks', 'order_for', 'status', 'created_by',
                'approved_by', 'approved_at', 'updated_by', 'created_at', 'updated_at'
            ];

            DB::transaction(function () use ($handle, $header, $existingColumns) {
                while (($data = fgetcsv($handle, 5000, ',')) !== false) {
                    // Map the header to the data so you can refer to columns by name
                    $row = array_combine($header, $data);

                    // Replace "NULL" strings with actual null
                    $row = array_map(function($value) {
                        return $value === 'NULL' ? null : $value;
                    }, $row);

                    // Filter the data to include only columns that exist in the orders table
                    $filteredData = array_intersect_key($row, array_flip($existingColumns));

                    // Insert the filtered data into the orders table
                    Order::create($filteredData);
                }
            });

            fclose($handle);
        }
    }



}
