<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Product\DeleteFeaturedProductRequest;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateBuyLimitsRequest;
use App\Imports\importProduct;
use App\Traits\UserStatusTrait;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\Product\StoreFeaturedProductRequest;
use App\Models\Product;
use App\Models\ImportedPorduct;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ChildCategory;
use App\Models\QuestionCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProductRestockNotification;
use App\Models\ProductVariant;
use App\Models\ProductNotification;
use App\Models\FeaturedProduct;
use App\Models\ProductAttribute;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Yajra\DataTables\Facades\DataTables;
use League\Csv\Writer;
use SplTempFileObject;

class ProductController extends Controller
{
    use UserStatusTrait;

    public function products(Request $request)
    {
        $user = $this->getAuthUser();
        $this->authorize('products');

        $data = [];
        if ($user->hasRole('super_admin')) {
            if ($request->ajax()) {
                $query = Product::with('category:id,name', 'sub_cat:id,name', 'child_cat:id,name')
                    ->whereIn('status', $this->getUserStatus('Active'));

                return DataTables::of($query)
                    ->filter(function ($query) use ($request) {
                        if ($request->filled('title')) {
                            $query->where('title', 'like', "%{$request->title}%");
                        }

                        if ($request->filled('category_id')) {
                            $query->where('category_id', $request->category_id);
                        }

                        if ($request->filled('sub_cat_id')) {
                            $query->where('sub_cat_id', $request->sub_cat_id);
                        }

                        if ($request->filled('child_cat_id')) {
                            $query->where('child_cat_id', $request->child_cat_id);
                        }
                    })
                    ->addColumn('details', function ($product) {
                        $imageUrl = asset('storage/' . $product->main_image);
                        $title = $product->title ?? '';
                        $barcode = $product->barcode ?? '';

                        return '<div class="d-flex align-items-center">
                                    <img src="' . $imageUrl . '" class="rounded-circle" alt="no image" style="width: 45px; height: 45px" />
                                    <div class="ms-3">
                                        <p class="fw-bold mb-1">' . $title . '</p>
                                        <p class="text-muted mb-0">' . $barcode . '</p>
                                    </div>
                                </div>';
                    })
                    ->addColumn('actions', function ($product) {
                        $previewUrl = route('web.product', ['id' => $product->slug]);

                        return '<div style="display:flex; justify-content: space-around;">
                                    <div>
                                        <a class="edit" style="cursor: pointer;" title="Edit" data-id="' . $product->id . '" data-toggle="tooltip">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a target="_blank" href="' . $previewUrl . '" class="preview" style="cursor: pointer; font-size:larger;" title="Preview" data-id="' . $product->id . '" data-toggle="tooltip">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </div>
                                    <div>
                                        <a class="duplicate" style="cursor: pointer;" title="Duplicate Product" data-id="' . $product->id . '" data-toggle="tooltip">
                                            <i class="bi bi-copy"></i>
                                        </a>
                                        <a class="delete" style="cursor: pointer;" title="Delete" data-status="' . config('constants.STATUS')['Deactive'] . '" data-id="' . $product->id . '" data-toggle="tooltip">
                                            <i class="bi bi-trash-fill"></i>
                                        </a>
                                    </div>
                                </div>';
                    })
                    ->editColumn('product_template', function ($product) {
                        $templates = config('constants.PRODUCT_TEMPLATES');
                        return $templates[$product->product_template] ?? 'Unknown'; // Handle missing keys
                    })
                    ->editColumn('status', function ($product) {
                        return '<span class="badge ' . ($product->status == 1 ? 'bg-success' : 'bg-danger') . ' rounded-pill d-inline">'
                            . ($product->status == 1 ? 'Active' : 'Deactive') . '</span>';
                    })
                    ->rawColumns(['details', 'status', 'actions'])
                    ->addIndexColumn() // Add index column if needed
                    ->make(true);
            }

            $productsFilter = Product::with('category:id,name', 'sub_cat:id,name', 'child_cat:id,name')
                ->where('status', [$this->getUserStatus('Active')])
                ->latest('id')->get();
            $data['filters'] = [];
            if ($productsFilter->isNotEmpty()) {
                $data['filters']['titles'] = array_unique($productsFilter->pluck('title')->toArray());
                $data['filters']['categories'] = $productsFilter->pluck('category.name')->unique()->values()->all();
                $data['filters']['sub_cat'] = $productsFilter->pluck('sub_cat.name')->unique()->values()->all();
                $data['filters']['child_cat'] = $productsFilter->pluck('child_cat.name')->unique()->values()->all();
                $data['filters']['templates'] = array_unique($productsFilter->pluck('product_template')->toArray());
            }
        }

        return view('admin.pages.products.products', $data);
    }

    public function product_trash()
    {
        $user = $this->getAuthUser();
        $this->authorize('products');

        if ($user->hasRole('super_admin')) {
            $products = Product::with('category:id,name', 'sub_cat:id,name', 'child_cat:id,name')->whereIn('status', $this->getUserStatus('Deactive'))->latest('id')->get()->toArray();
            $data['filters'] = [];
            if ($products) {
                $data['filters']['titles'] = array_unique(array_column($products, 'title'));
                $data['filters']['categories'] = collect($products)->pluck('category.name')->unique()->values()->all();
                $data['filters']['sub_cat'] = collect($products)->pluck('sub_cat.name')->unique()->values()->all();
                $data['filters']['child_cat'] = collect($products)->pluck('child_cat.name')->unique()->values()->all();
                $data['filters']['templates'] = array_unique(array_column($products, 'product_template'));
                $data['products'] = $products;
            }
        }

        return view('admin.pages.products.product_trash', $data);
    }

    public function imported_products()
    {
        $user = $this->getAuthUser();
        $this->authorize('products');

        if ($user->hasRole('super_admin')) {
            $data['products'] = ImportedPorduct::latest('id')->get()->toArray();
        }
        return view('admin.pages.products.imported_products', $data);
    }

    public function products_limits()
    {
        $user = $this->getAuthUser();
        $this->authorize('products');

        if ($user->hasRole('super_admin')) {
            $data['products'] = Product::with('category:id,name')->latest('id')->get()->toArray();
        }
        // dd($data['products']);
        return view('admin.pages.products.prodcuts_limits', $data);
    }

    public function import_products()
    {
        $data['user'] = $this->getAuthUser();
        $this->authorize('products');

        return view('admin.pages.products.import_products', $data);
    }

    public function featured_products()
    {
        $data['user'] = $this->getAuthUser();
        $this->authorize('featured_products');

        $data['products'] = Product::with('variants')->where('status', $this->getUserStatus('Active'))->latest('id')->get()->sortBy('title')->values()->keyBy('id')->toArray();


        $data['f_products'] = FeaturedProduct::with('product')
            ->orderBy('id', 'desc')
            ->take(6)
            ->get()->toArray();
        return view('admin.pages.products.featured_products', $data);
    }

    public function store_featured_products(StoreFeaturedProductRequest $request)
    {
        $user = $this->getAuthUser();
        $this->authorize('add_product');

        // Update or create a new featured product
        $featuredProduct = FeaturedProduct::updateOrCreate(
            ['id' => $request->id ?? null],
            [
                'product_id' => $request->product_id,
                'created_by' => $user->id,
            ]
        );

        $message = "Featured Product " . ($request->id ? "Updated" : "Saved") . " Successfully";

        return response()->json(['status' => 'success', 'message' => $message]);
    }


    public function store_import_products(Request $request)
    {
        $file = $request->file('file');
        if (!$file) {
            return response()->json(['error' => 'No file uploaded']);
        }

        $extension = $file->getClientOriginalExtension();
        if ($extension === 'xlsx') {
            $fileType = 'xlsx';
        } elseif ($extension === 'csv') {
            $fileType = 'csv';
        } else {
            return response()->json(['error' => 'Invalid file type']);
        }

        $filePath = $file->getRealPath();
        Excel::import(new importProduct, $filePath, null, \Maatwebsite\Excel\Excel::XLSX);
        return redirect()->route('admin.importedProdcuts')->with(['message' => 'File imported successfully']);
    }

    public function add_product(Request $request)
    {
        $this->authorize('add_product');

        $data['categories'] = Category::where('status', 'Active')->latest('id')->get()->toArray();
        $data['templates'] = config('constants.PRODUCT_TEMPLATES');
        $data['question_category'] = QuestionCategory::latest('id')->get()->toArray();
        $data['product'] = [];
        $data['duplicate'] = 'no';
        if ($request->has('id')) {
            $data['duplicate'] = $request->duplicate;
            if (isset($request->imported) && $request->imported == 'yes') {
                $data['product'] = ImportedPorduct::findOrFail($request->id)->toArray();
                $data['product']['id'] = Null;
            } else {
                $data['product'] = Product::with('productAttributes:id,product_id,image', 'variants')->findOrFail($request->id)->toArray();
                $data['sub_category'] = SubCategory::select('id', 'name')
                    ->where(['category_id' => $data['product']['category_id'], 'status' => 'Active'])
                    ->pluck('name', 'id')
                    ->toArray();

                $data['child_category'] = ChildCategory::select('id', 'name')
                    ->where(['sub_category_id' => $data['product']['sub_category'], 'status' => 'Active'])
                    ->pluck('name', 'id')
                    ->toArray();

                $data['prod_question'] = explode(',', $data['product']['question_category']);
            }
        }
        return view('admin.pages.products.add_product', $data);
    }

    public function sendStockNotificationForProduct($productId)
    {
        // Fetch the product
        $product = Product::findOrFail($productId);
    
        // Check if the product is in stock
        if ($product->stock > 0 || $product->stock_status == 'IN' ) {
            // Fetch all users who registered for notifications for this product
            $notifications = ProductNotification::where('product_id', $productId)->get();
    
            // Check if there are any notifications
            if ($notifications->isEmpty()) {
                return;
            }
    
            // Send email to each user
            foreach ($notifications as $notification) {
                Mail::to($notification->email)
                    ->send(new ProductRestockNotification($productId));
            }
        }
    }

    public function store_product(StoreProductRequest $request)
    {
        $user = $this->getAuthUser();

        $this->authorize('add_product');

        // Handle the main image upload
        if ($request->hasFile('main_image')) {
            $mainImage = $request->file('main_image');
            $mainImageName = time() . '_' . uniqid('', true) . '.' . $mainImage->getClientOriginalExtension();
            $mainImage->storeAs('product_images/main_images', $mainImageName, 'public');
            $mainImagePath = 'product_images/main_images/' . $mainImageName;
        }

        $question_category = $request->question_category ? implode(",", $request->question_category) : null;

        // Create or update the product
        $product = Product::updateOrCreate(
            ['id' => (isset($request->id) && $request->duplicate == 'no') ? $request->id : null],
            [
                'title' => ucwords($request->title),
                'desc' => $request->desc,
                'short_desc' => $request->short_desc ?? null,
                'main_image' => $mainImagePath ?? Product::findOrFail($request->id)->main_image,
                'category_id' => $request->category_id,
                'sub_category' => $request->sub_category ?? null,
                'child_category' => $request->child_category ?? null,
                'product_template' => $request->product_template ?? null,
                'question_category' => $question_category ?? null,
                'cut_price' => $request->cut_price,
                'barcode' => $request->barcode,
                'SKU' => $request->SKU,
                'weight' => $request->weight ?? 0,
                'stock' => $request->stock,
                'stock_status' => $request->stock_status,
                'high_risk'      => $request->high_risk,
                'leaflet_link'   => $request->leaflet_link,
                'price' => $request->price,
                'status' => $this->getUserStatus('Active'),
                'created_by' => $user->id,
            ]
        );

        if ($product) {
            // Handle additional image uploads
            $uploadedImages = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $image->storeAs('product_images', $imageName, 'public');
                    $uploadedImages[] = 'product_images/' . $imageName;
                }

                // Insert product attributes (images)
                foreach ($uploadedImages as $uploadedImage) {
                    DB::table('product_attributes')->insert([
                        'product_id' => $product->id,
                        'image' => $uploadedImage,
                        'status' => $this->getUserStatus('Active'),
                        'created_by' => $user->id,
                    ]);
                }
            }

            // Handle product variations
            if ($request->filled('vari_value')) {
                $this->handleProductVariations($request, $product);
            }

            // Handle existing variant updates
            if (isset($request['exist_vari_value']) && $request->duplicate == 'no') {
                $this->updateExistingVariants($request);
            }

            // Handle variant duplication
            if (isset($request['exist_vari_value']) && $request->duplicate == 'yes') {
                $this->duplicateVariants($request, $product);
            }
        }

         // After updating or creating, check stock and notify users
         $this->sendStockNotificationForProduct($product->id);

        $message = "Product " . ($request->id ? "Updated" : "Saved") . " Successfully";
        return response()->json(['status' => 'success', 'message' => $message, 'data' => []]);
    }

    private function handleProductVariations($request, $product)
    {
        $valueArr = $request['vari_value'];
        $priceArr = $request['vari_price'];
        $cutPriceArr = $request['vari_cut_price'];
        $skuArr = $request['vari_sku'];
        $nameArr = $request['vari_name'];
        $barcodeArr = $request['vari_barcode'];
        $inventoryArr = $request['vari_inventory'];
        $weightArr = $request['vari_weight'] ?? 0;

        foreach ($skuArr as $key => $val) {
            $variantData = [
                'product_id' => $product->id,
                'title' => $nameArr[$key],
                'price' => $priceArr[$key],
                'cut_price' => $cutPriceArr[$key],
                'value' => $valueArr[$key],
                'slug' => SlugService::createSlug(ProductVariant::class, 'slug', $request->title . ' ' . $valueArr[$key], ['unique' => false]),
                'barcode' => $barcodeArr[$key],
                'inventory' => $inventoryArr[$key],
                'sku' => $skuArr[$key],
                'weight' => $weightArr[$key] ?? 0,
                'image' => $this->handleVariantImage($request, $key, "vari_attr_images"),
            ];

            DB::table('product_variants')->insert($variantData);
        }
    }

    private function updateExistingVariants($request)
    {
        $idArrExist = $request['exist_vari_id'];
        $valueArrExist = $request['exist_vari_value'];
        $priceArrExist = $request['exist_vari_price'];
        $cutPriceArrExist = $request['exist_vari_cut_price'];
        $skuArrExist = $request['exist_vari_sku'];
        $nameArrExist = $request['exist_vari_name'];
        $barcodeArrExist = $request['exist_vari_barcode'];
        $inventoryArrExist = $request['exist_vari_inventory'];
        $weightArrExist = $request['exist_vari_weight'] ?? 0;

        foreach ($skuArrExist as $key => $val) {
            $variantId = $idArrExist[$key];

            $variantData = [
                'title' => $nameArrExist[$key],
                'price' => $priceArrExist[$key],
                'cut_price' => $cutPriceArrExist[$key],
                'value' => $valueArrExist[$key],
                'slug' => SlugService::createSlug(ProductVariant::class, 'slug', $request->title . ' ' . $valueArrExist[$key], ['unique' => false]),
                'barcode' => $barcodeArrExist[$key],
                'inventory' => $inventoryArrExist[$key],
                'sku' => $skuArrExist[$key],
                'weight' => $weightArrExist[$key] ?? 0,
            ];

            if ($request->hasFile("exist_vari_attr_images.$variantId")) {
                $variantData['image'] = $this->handleVariantImage($request, $variantId, "exist_vari_attr_images");
            }

            DB::table('product_variants')->where('id', $variantId)->update($variantData);
        }
    }

    private function duplicateVariants($request, $product)
    {
        $valueArrExist = $request['exist_vari_value'];
        $priceArrExist = $request['exist_vari_price'];
        $cutPriceArrExist = $request['exist_vari_cut_price'];
        $skuArrExist = $request['exist_vari_sku'];
        $nameArrExist = $request['exist_vari_name'];
        $barcodeArrExist = $request['exist_vari_barcode'];
        $inventoryArrExist = $request['exist_vari_inventory'];
        $weightArrExist = $request['exist_vari_weight'] ?? 0;

        foreach ($skuArrExist as $key => $val) {
            $variantData = [
                'product_id' => $product->id,
                'title' => $nameArrExist[$key],
                'price' => $priceArrExist[$key],
                'cut_price' => $cutPriceArrExist[$key],
                'value' => $valueArrExist[$key],
                'barcode' => $barcodeArrExist[$key],
                'inventory' => $inventoryArrExist[$key],
                'sku' => $skuArrExist[$key],
                'weight' => $weightArrExist[$key] ?? 0,
                'image' => $this->handleVariantImage($request, $key, "exist_vari_attr_images"),
            ];

            DB::table('product_variants')->insert($variantData);
        }
    }

    private function handleVariantImage($request, $key, $imageField)
    {
        if ($request->hasFile("$imageField.$key")) {
            $image = $request->file("$imageField.$key");
            $imageName = time() . '_' . uniqid('', true) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('product_images/main_images', $imageName, 'public');
            return 'product_images/main_images/' . $imageName;
        }
        return null;
    }


    public function update_buy_limits(UpdateBuyLimitsRequest $request)
    {
        $this->authorize('add_product');

        // Find the product and update the limits
        $product = Product::findOrFail($request->id);
        $product->update([
            'min_buy' => $request->min_buy,
            'max_buy' => $request->max_buy,
            'comb_variants' => $request->comb_variants,
        ]);

        $message = "Product Limits " . ($request->id ? "Updated" : "Saved") . " Successfully";
        return response()->json(['status' => 'success', 'message' => $message, 'data' => []]);
    }


    public function delete_variant(Request $request)
    {
        $id = $request->id;
        $variant = new ProductVariant;
        $variant = ProductVariant::find($id);
        $response = $variant->delete($id);
        if ($response) {
            return response()->json(['status' => 'success', 'message' => 'Record Deleted']);
        }
    }

    public function update_status(Request $request)
    {
        $this->authorize('add_product');

        $product = Product::findOrFail($request->id);
        $product->update([
            'status' => $request->status,
        ]);

        $message = "Product status " . ($request->id ? "Updated" : "Saved") . " Successfully";
        return response()->json(['status' => 'success', 'message' => $message, 'data' => []]);
    }

    public function delete_featured_products(DeleteFeaturedProductRequest $request)
    {
        $product_id = $request->product_id;

        $featuredProduct = FeaturedProduct::where('product_id', $product_id)->first();

        if ($featuredProduct) {
            $featuredProduct->delete();
            return response()->json(['status' => 'success', 'message' => 'Product deleted successfully']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Product not found']);
        }
    }

    public function delete_product_attribute(Request $request)
    {
        $productAttributeId = $request->input('id');
        $productAttribute = ProductAttribute::find($productAttributeId);

        if ($productAttribute) {
            $productAttribute->delete();
            return response()->json(['status' => 'success', 'message' => 'Product attribute deleted successfully']);
        }

        return response()->json(['status' => 'error', 'message' => 'Product attribute not found']);
    }

    public function search_products(Request $request)
    {
        $user = $this->getAuthUser();
        $this->authorize('products');

        $data = [];
        if ($user->hasRole('super_admin')) {
            $products = Product::with('category:id,name', 'sub_cat:id,name', 'child_cat:id,name')
                ->where('title', 'like', '%' . $request->string . '%')
                ->whereIn('status', $this->getUserStatus('Active'))
                ->latest('id')
                ->paginate(50); // Set pagination to 50 items per page

            return response()->json(['status' => 'success', 'data' => $products]);
        }
    }

    public function exportCSV()
    {
        // Fetch product details
        $products = Product::all();

        // Create CSV writer instance
        $csv = Writer::createFromFileObject(new SplTempFileObject());

        // Add CSV header
        $csv->insertOne([
            'ID', 'Title', 'Slug', 'Short Description', 'Description', 'Main Image',
            'Sale Price', 'Stock', 'Availability', 'Weight', 'Min Buy', 'Max Buy', 'Combination Variants',
            'SKU', 'Barcode', 'Price', 'Product Type', 'Sub Category', 'Child Category',
            'Product Template', 'Question Category', 'Status', 'Created By', 'Updated By',
            'Created At', 'Updated At'
        ]);

        // Define base URL for slug and main image
        $baseUrl = 'https://onlinepharmacy-4u.co.uk';

        // Fetch categories and their names for lookup
        $categories = Category::all()->keyBy('id');
        $subCategories = SubCategory::all()->keyBy('id');
        $childCategories = ChildCategory::all()->keyBy('id');

        // Add product data
        foreach ($products as $product) {
            $categoryName = $categories->get($product->category_id)->name ?? 'N/A';
            $subCategoryName = $subCategories->get($product->sub_category_id)->name ?? 'N/A';
            $childCategoryName = $childCategories->get($product->child_category_id)->name ?? 'N/A';

            $csv->insertOne([
                $product->id,
                $product->title,
                $baseUrl . '/product/' . $product->slug, // Full URL for slug
                strip_tags($product->short_desc), // Remove HTML tags
                strip_tags($product->desc), // Remove HTML tags
                $baseUrl . '/storage/' . $product->main_image, // Full URL for main image
                $product->price,
                $product->stock,
                $product->stock_status,
                $product->weight . '(g)',
                $product->min_buy,
                $product->max_buy,
                $product->comb_variants,
                $product->SKU,
                $product->barcode,
                $product->cut_price,
                $categoryName,
                $subCategoryName,
                $childCategoryName,
                $product->product_template,
                $product->question_category,
                $product->status,
                $product->created_by,
                $product->updated_by,
                $product->created_at,
                $product->updated_at
            ]);
        }

        // Prepare the CSV for download
        $csvData = $csv->toString();
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="products.csv"',
        ];

        return Response::make($csvData, 200, $headers);
    }

}
