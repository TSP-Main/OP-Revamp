<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product; // Ensure this path matches your Product model
use League\Csv\Writer;
use SplTempFileObject;

class ExportProductsCSV extends Command
{
    protected $signature = 'products:exportcsv';
    protected $description = 'Export product details to a CSV file';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Fetch product details
        $products = Product::all();

        // Create CSV writer instance
        $csv = Writer::createFromFileObject(new SplTempFileObject());

        // Add CSV header based on your table schema
        $csv->insertOne([
            'ID', 'Title', 'Slug', 'Short Description', 'Description', 'Main Image', 
            'Price', 'Stock', 'Weight', 'Min Buy', 'Max Buy', 'Combination Variants', 
            'SKU', 'Barcode', 'Cut Price', 'Category ID', 'Sub Category', 'Child Category', 
            'Product Template', 'Question Category', 'Status', 'Created By', 'Updated By',
            'Created At', 'Updated At'
        ]);

        // Add product data
        foreach ($products as $product) {
            $csv->insertOne([
                $product->id,
                $product->title,
                $product->slug,
                $product->short_desc,
                $product->desc,
                $product->main_image,
                $product->price,
                $product->stock,
                $product->weight,
                $product->min_buy,
                $product->max_buy,
                $product->comb_variants,
                $product->SKU,
                $product->barcode,
                $product->cut_price,
                $product->category_id,
                $product->sub_category,
                $product->child_category,
                $product->product_template,
                $product->question_category,
                $product->status,
                $product->created_by,
                $product->updated_by,
                $product->created_at,
                $product->updated_at
            ]);
        }

        // Save CSV to a file
        $filePath = storage_path('app/products.csv');

        // Use file_put_contents to write the CSV data to the file
        $csvData = $csv->toString(); // Get CSV data as a string
        file_put_contents($filePath, $csvData); // Save to file

        $this->info("CSV file has been saved to {$filePath}");
    }
}
