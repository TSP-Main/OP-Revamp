<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ShippingDetail;
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
        set_time_limit(360);

        // Validate the incoming request for a CSV file
        $request->validate([
            'csv' => 'required|file|mimes:csv,txt',
        ]);

        if (($handle = fopen($request->file('csv'), 'r')) !== false) {
            fgetcsv($handle); // Skip the header row

            DB::transaction(function () use ($handle) {
                while (($data = fgetcsv($handle, 5000, ',')) !== false) {
                    $data = array_map(function ($value) {
                        return $value === 'NULL' ? null : $value;
                    }, $data);

                    // Validate and convert date format for DOB
                    $dateOfBirth = null;
                    if (!empty($data[5])) {
                        try {
                            $dateOfBirth = Carbon::createFromFormat('d-m-Y', $data[5])->format('Y-m-d');
                        } catch (InvalidFormatException $e) {
                            \Log::error("Invalid date format for DOB: {$data[5]} - Error: " . $e->getMessage());
                        }
                    }

                    $existingUser = User::where('email', $data[2])->first();

                    if ($existingUser) {
                        // Update existing user without automatic timestamps
                        $existingUser->update([
                            'name' => $data[1],
                            'email_verified_at' => $data[3],
                            'password' => bcrypt($data[6]),
                            'id_document' => $data[11],
                            'updated_by' => $data[29],
                        ]);

                        // Update or create user profile and address
                        $existingUser->profile()->updateOrCreate(
                            ['user_id' => $existingUser->id],
                            [
                                'speciality' => $data[22],
                                'phone' => $data[9],
                                'gender' => $data[4],
                                'date_of_birth' => $dateOfBirth,
                                'image' => $data[23],
                                'profile_status' => $data[25],
                                'consult_status' => $data[26],
                                'updated_at' => $data[32],  // Use timestamp from CSV
                            ]
                        );

                        $existingUser->address()->updateOrCreate(
                            ['user_id' => $existingUser->id],
                            [
                                'address' => $data[10],
                                'apartment' => $data[12],
                                'city' => $data[17],
                                'state' => $data[18],
                                'country' => $data[15],
                                'zip_code' => $data[16],
                                'updated_at' => $data[32],  // Use timestamp from CSV
                            ]
                        );
                    } else {
                        // Create a new user using withoutTimestamps() to prevent overrides
                        $user = User::withoutTimestamps(function () use ($data) {
                            return User::create([
                                'name' => $data[1],
                                'email' => $data[2],
                                'email_verified_at' => $data[3],
                                'password' => bcrypt($data[6]),
                                'id_document' => $data[11],
                                'status' => 2,
                                'created_by' => $data[28],
                                'updated_by' => $data[29],
                                'created_at' => $data[31], // CSV timestamp
                                'updated_at' => $data[32], // CSV timestamp
                            ]);
                        });

                        // Create user profile and address without automatic timestamps
                        UserProfile::withoutTimestamps(function () use ($user, $data, $dateOfBirth) {
                            UserProfile::create([
                                'user_id' => $user->id,
                                'speciality' => $data[22],
                                'phone' => $data[9],
                                'gender' => $data[4],
                                'date_of_birth' => $dateOfBirth,
                                'image' => $data[23],
                                'profile_status' => 'pending',
                                'consult_status' => 'pending',
                                'created_at' => $data[31], // CSV timestamp
                                'updated_at' => $data[32], // CSV timestamp
                            ]);
                        });

                        UserAddress::withoutTimestamps(function () use ($user, $data) {
                            UserAddress::create([
                                'user_id' => $user->id,
                                'address' => $data[10],
                                'apartment' => $data[12],
                                'city' => $data[17],
                                'state' => $data[18],
                                'country' => $data[15],
                                'zip_code' => $data[16],
                                'created_at' => $data[31], // CSV timestamp
                                'updated_at' => $data[32], // CSV timestamp
                            ]);
                        });
                    }
                }
            });

            fclose($handle);
        }

        return redirect()->back()->with('success', 'User data imported successfully!');
    }



    public function importOrdersData(Request $request)
    {
        set_time_limit(360);

        if (($handle = fopen($request->file('csv'), 'r')) !== false) {
            $header = fgetcsv($handle, 5000, ',');

            $existingColumns = [
                'id',
                'user_id',
                'note',
                'print',
                'total_ammount',
                'payment_id',
                'payment_status',
                'hcp_remarks',
                'order_for',
                'status',
                'created_by',
                'approved_by',
                'approved_at',
                'updated_by',
                'created_at',
                'updated_at'
            ];

            DB::transaction(function () use ($handle, $header, $existingColumns) {
                while (($data = fgetcsv($handle, 5000, ',')) !== false) {
                    $row = array_combine($header, $data);

                    $row = array_map(function ($value) {
                        return $value === 'NULL' ? null : $value;
                    }, $row);

                    $filteredData = array_intersect_key($row, array_flip($existingColumns));

                    // Use withoutTimestamps() to ensure the provided timestamps are used
                    Order::withoutTimestamps(function () use ($filteredData) {
                        Order::create($filteredData);
                    });
                }
            });

            fclose($handle);
        }
    }

    public function importOrderDetailsData(Request $request)
    {
        if (($handle = fopen($request->file('csv'), 'r')) !== false) {
            // Read the header row from the CSV file
            $header = fgetcsv($handle, 5000, ',');

            // Ensure the headers match the database table columns exactly
            $validColumns = [
                'id',
                'order_id',
                'product_id',
                'variant_id',
                'product_status',
                'product_qty',
                'generic_consultation',
                'product_consultation',
                'consultation_type',
                'created_by',
                'created_at',
                'updated_at'
            ];

            DB::transaction(function () use ($handle, $header, $validColumns) {
                while (($data = fgetcsv($handle, 5000, ',')) !== false) {
                    // Skip rows with a different number of columns than the header
                    if (count($header) !== count($data)) {
                        continue; // Skip this row and move to the next
                    }

                    // Map the CSV header to the data row
                    $row = array_combine($header, $data);

                    // Replace "NULL" strings with actual null values
                    $row = array_map(function ($value) {
                        return $value === 'NULL' ? null : $value;
                    }, $row);

                    // Filter the row to keep only valid columns for insertion
                    $filteredData = array_intersect_key($row, array_flip($validColumns));

                    // Use withoutTimestamps() to ensure the provided timestamps are used
                    OrderDetail::withoutTimestamps(function () use ($filteredData) {
                        OrderDetail::create($filteredData);
                    });
                }
            });

            fclose($handle);
        }
    }

    public function importShippingDetails(Request $request)
    {
        if (($handle = fopen($request->file('csv'), 'r')) !== false) {
            // Read the header row from the CSV file
            $header = fgetcsv($handle, 5000, ',');

            // Ensure these columns match the ones in your shipping_details table
            $validColumns = [
                'id',
                'order_id',
                'user_id',
                'method',
                'cost',
                'firstName',
                'lastName',
                'email',
                'order_identifier',
                'tracking_no',
                'phone',
                'city',
                'state',
                'zip_code',
                'address',
                'address2',
                'status',
                'shipping_status',
                'created_by',
                'updated_by',
                'created_at',
                'updated_at'
            ];

            DB::transaction(function () use ($handle, $header, $validColumns) {
                while (($data = fgetcsv($handle, 5000, ',')) !== false) {
                    // Check for consistent column counts
                    if (count($header) !== count($data)) {
                        continue; // Skip inconsistent rows
                    }

                    // Map header to data row
                    $row = array_combine($header, $data);

                    // Replace "NULL" strings with actual null values
                    $row = array_map(function ($value) {
                        return $value === 'NULL' ? null : $value;
                    }, $row);

                    // Filter the row to include only valid columns for shipping_details
                    $filteredData = array_intersect_key($row, array_flip($validColumns));

                    // Use withoutTimestamps() to ensure the provided timestamps are used
                    ShippingDetail::withoutTimestamps(function () use ($filteredData) {
                        ShippingDetail::create($filteredData);
                    });
                }
            });

            fclose($handle);
        }
    }
}
