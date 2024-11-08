<?php

namespace App\Imports;

use App\Models\ImportedPorduct;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class importProduct implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        $data = [];

        foreach ($collection as $row) {
            // Check if any of the required fields have values
            if ($row[0] != '') {
                // Map the row data to match the order of columns in the database table
                $data[] = [
                    'title' => $row[0],
                    'desc' => $row[1],
                    'category' => $row[2],
                    'type' => $row[3] ?? null,
                    'published' => $row[4] ?? null,
                    'sku' => $row[5] ?? null,
                    'weight' => $row[6] ?? null,
                    'inventory_qty' => $row[7] ?? null,
                    'inventory_policy' => $row[8] ?? null,
                    'price' => $row[9],
                    'compare_price' => $row[10] ?? null,
                    'barcode' => $row[11] ?? null,
                    'status' => $row[12] ?? null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Chunk the data array and insert each chunk into the database
        $chunkedData = array_chunk($data, 500);

        foreach ($chunkedData as $chunk) {
            ImportedPorduct::insert($chunk);
        }
    }

    /**
     * Check if a row is empty (all fields are null or empty strings)
     *
     * @param array $row
     * @return bool
     */

}