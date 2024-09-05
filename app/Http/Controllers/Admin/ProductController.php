<?php

namespace App\Http\Controllers\Admin;

use App\Imports\importProduct;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\Product;
use App\Models\User;
use App\Models\ImportedPorduct;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ChildCategory;
use App\Models\QuestionCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\ProductVariant;
use App\Models\FeaturedProduct;
use App\Models\ProductAttribute;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Yajra\DataTables\Facades\DataTables;
use League\Csv\Writer;
use SplTempFileObject;
use Response;

class ProductController extends Controller
{
    protected $status;
    protected $user;

    public function __construct()
    {
        $this->user = auth()->user();
        $this->status = config('constants.STATUS');
    }

    public function products(Request $request)
    {
        $user = auth()->user();
        $page_name = 'prodcuts';
        if (!view_permission($page_name)) {
            return redirect()->back();
        }

        $data = [];
        if (isset($user->role) && $user->role == user_roles('1')) {

            if ($request->ajax()) {
                $query = Product::with('category:id,name', 'sub_cat:id,name', 'child_cat:id,name')
                    ->whereIn('status', [$this->status['Active']]);

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
                ->whereIn('status', [$this->status['Active']])
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

        return view('admin.pages.products.prodcuts', $data);
    }

    public function product_trash(Request $request)
    {
        $user = auth()->user();
        $page_name = 'prodcuts';
        if (!view_permission($page_name)) {
            return redirect()->back();
        }

        if (isset($user->role) && $user->role == user_roles('1')) {
            $products = Product::with('category:id,name', 'sub_cat:id,name', 'child_cat:id,name')->whereIn('status', [$this->status['Deactive']])->latest('id')->get()->toArray();
            $data['filters'] = [];
            if ($products) {
                $data['filters']['titles'] = array_unique(array_column($products, 'title'));
                $data['filters']['categories'] =  collect($products)->pluck('category.name')->unique()->values()->all();
                $data['filters']['sub_cat'] =  collect($products)->pluck('sub_cat.name')->unique()->values()->all();
                $data['filters']['child_cat'] =  collect($products)->pluck('child_cat.name')->unique()->values()->all();
                $data['filters']['templates'] = array_unique(array_column($products, 'product_template'));
                $data['products'] = $products;
            }
        }

        return view('admin.pages.products.prodcut_trash', $data);
    }

    public function imported_products(Request $request)
    {
        $user = auth()->user();
        $page_name = 'prodcuts';
        if (!view_permission($page_name)) {
            return redirect()->back();
        }

        if (isset($user->role) && $user->role == user_roles('1')) {
            $data['products'] = ImportedPorduct::latest('id')->get()->toArray();
        }
        return view('admin.pages.products.imported_prodcuts', $data);
    }

    public function products_limits(Request $request)
    {
        $user = auth()->user();
        $page_name = 'prodcuts';
        if (!view_permission($page_name)) {
            return redirect()->back();
        }

        if (isset($user->role) && $user->role == user_roles('1')) {
            $data['products'] = Product::with('category:id,name')->latest('id')->get()->toArray();
        }
        // dd($data['products']);
        return view('admin.pages.products.prodcuts_limits', $data);
    }

    public function import_products()
    {
        $data['user'] = auth()->user();
        $page_name = 'prodcuts';
        if (!view_permission($page_name)) {
            return redirect()->back();
        }

        return view('admin.pages.products.import_products', $data);
    }

    public function featured_products(Request $request)
    {
        $data['user'] = auth()->user();

        $page_name = 'featured_products';
        if (!view_permission($page_name)) {
            return redirect()->back();
        }

        $data['products'] = Product::with('variants')->where('status', $this->status['Active'])->latest('id')->get()->sortBy('title')->values()->keyBy('id')->toArray();


        $data['f_products'] = FeaturedProduct::with('product')
            ->orderBy('id', 'desc')
            ->take(6)
            ->get()->toArray();
        return view('admin.pages.products.featured_products', $data);
    }

    public function store_featured_products(Request $request)
    {
        $user = auth()->user();
        $page_name = 'add_product';
        if (!view_permission($page_name)) {
            return response()->json(['status' => 'error', 'message' => 'Permission Denied']);
        }
        $rules = ['product_id' => 'required|exists:products,id'];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()]);
        }

        $featuredProduct = FeaturedProduct::updateOrCreate(
            ['id' => $request->id ?? Null],
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
        $user = auth()->user();
        $page_name = 'add_product';
        if (!view_permission($page_name)) {
            return redirect()->back();
        }
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
        // dd($data['product']);
        return view('admin.pages.products.add_product', $data);
    }

    public function store_product(Request $request)
    {
        $user = auth()->user();
        $page_name = 'add_product';
        if (!view_permission($page_name)) {
            return redirect()->back();
        }

        $rules = [
            'price'             => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'category_id'       => 'required',
            'product_template'  => 'required',
            'stock'             => 'required',
            'stock_status'      => 'required',
            'cut_price'         => 'nullable|regex:/^\d+(\.\d{1,2})?$/',
            'desc'              => 'required',
            'title'             => [
                'required',
                Rule::unique('products')->ignore((isset($request->id) && $request->duplicate == 'no') ? $request->id : null),
            ],
        ];

        if ($request->id == null || !$request->id) {
            $rules['main_image'] = [
                'required',
                'image',
                'mimes:jpeg,png,jpg,gif,webm,svg,webp',
                'max:1024',
                // 'dimensions:min_width=1000,min_height=1000',
            ];
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()]);
        }

        $data['user'] = auth()->user();
        if ($request->hasFile('main_image')) {

            $rules['main_image'] = [
                'required',
                'image',
                'mimes:jpeg,png,jpg,gif,webm,svg,webp',
                'max:1024',
                // 'dimensions:min_width=1000,min_height=1000',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['status' => 'error', 'message' => $validator->errors()]);
            }

            $mainImage = $request->file('main_image');
            $mainImageName = time() . '_' . uniqid('', true) . '.' . $mainImage->getClientOriginalExtension();
            $mainImage->storeAs('product_images/main_images', $mainImageName, 'public');
            $mainImagePath = 'product_images/main_images/' . $mainImageName;
        }

        $question_category = $request->question_category ? implode(",", $request->question_category) : NULL;

        // Create or update product
        $product = Product::updateOrCreate(
            ['id' => (isset($request->id) && $request->duplicate == 'no') ? $request->id : null],
            [
                'title'      => ucwords($request->title),
                // 'slug'       => SlugService::createSlug(Product::class, 'slug', $request->title),
                'desc'       => $request->desc,
                'short_desc' => $request->short_desc ?? Null,
                'main_image' => $mainImagePath ?? Product::findOrFail($request->id)->main_image,
                'category_id' => $request->category_id,
                'sub_category' => $request->sub_category ?? NULL,
                'child_category' => $request->child_category ?? NULL,
                'product_template' => $request->product_template ?? NULL,
                'question_category' => $question_category ?? NULL,
                'cut_price'    => $request->cut_price,
                'barcode'    => $request->barcode,
                'SKU'        => $request->SKU,
                'weight'     => $request->weight ?? 0,
                'stock'      => $request->stock,
                'stock_status' => $request->stock_status,
                'price'      => $request->price,
                'status'     => $this->status['Active'],
                'created_by' => $user->id,
            ]
        );

        if ($product) {
            // Handle image uploads
            $uploadedImages = [];
            if ($request->hasFile('images')) {

                foreach ($request->file('images') as $image) {
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $image->storeAs('product_images', $imageName, 'public'); // Change 'product_images' to your storage folder
                    $extImagePath = 'product_images/' . $imageName;

                    $uploadedImages[] = $extImagePath;
                }

                // Associate product attributes
                foreach ($uploadedImages as $uploadedImage) {
                    $productAttributesData[] = [
                        'product_id' => $product->id,
                        'image'      => $uploadedImage,
                        'status'     => $this->status['Active'],
                        'created_by' => $user->id,
                    ];
                }

                DB::table('product_attributes')->insert($productAttributesData);
            }


            // new variant
            if ($request['vari_value'] ?? NULL) {
                // handle the product variations .....
                $valueArr = $request['vari_value'];
                $priceArr = $request['vari_price'];
                $cutPriceArr = $request['vari_cut_price'];
                $skuArr   = $request['vari_sku'];
                $nameArr  = $request['vari_name'];
                $barcodeArr   = $request['vari_barcode'];
                $inventoryArr = $request['vari_inventory'];
                $weightArr = $request['vari_weight'] ?? 0;
                foreach ($skuArr as $key => $val) {

                    $productAttrArr['product_id'] = $product->id;
                    $productAttrArr['title'] = $nameArr[$key];
                    $productAttrArr['price'] = $priceArr[$key];
                    $productAttrArr['cut_price'] = $cutPriceArr[$key];
                    $productAttrArr['value'] = $valueArr[$key];
                    $productAttrArr['slug'] = SlugService::createSlug(ProductVariant::class, 'slug', $request->title . ' ' . $valueArr[$key], ['unique' => false]);
                    $productAttrArr['barcode'] = $barcodeArr[$key];
                    $productAttrArr['inventory'] = $inventoryArr[$key];
                    $productAttrArr['sku'] = $skuArr[$key];
                    $productAttrArr['weight'] = $weightArr[$key] ?? 0;

                    // Correcting the array key for variant images
                    if ($request->hasFile("vari_attr_images.$key")) {
                        $vari_Image = $request->file("vari_attr_images.$key");
                        $vari_ImageName = time() . '_' . uniqid('', true) . '.' . $vari_Image->getClientOriginalExtension();
                        $vari_Image->storeAs('product_images/main_images', $vari_ImageName, 'public');
                        $vari_ImagePath = 'product_images/main_images/' . $vari_ImageName;
                        $productAttrArr['image'] = $vari_ImagePath;
                    }

                    DB::table('product_variants')->insert($productAttrArr);
                }
            }

            // update variant
            if (isset($request['exist_vari_value']) && $request->duplicate == 'no') {
                // handle the product variations .....
                $idArrExist = $request['exist_vari_id'];
                $valueArrExist = $request['exist_vari_value'];
                $priceArrExist = $request['exist_vari_price'];
                $cutPriceArrExist = $request['exist_vari_cut_price'];
                $skuArrExist   = $request['exist_vari_sku'];
                $nameArrExist  = $request['exist_vari_name'];
                $barcodeArrExist   = $request['exist_vari_barcode'];
                $inventoryArrExist = $request['exist_vari_inventory'];
                $weightArrExist = $request['exist_vari_weight'] ?? 0;
                if ($request->hasFile('exist_vari_attr_images')) {
                    foreach ($request->file('exist_vari_attr_images') as $variantId => $image) {
                        if ($image) {
                            $variImageNameExist = time() . '_' . uniqid('', true) . '.' . $image->getClientOriginalExtension();
                            $variImagePathExist = $image->storeAs('product_images/main_images', $variImageNameExist, 'public');

                            $productAttrImage = ['image' => $variImagePathExist];

                            DB::table('product_variants')
                                ->where('id', $variantId)
                                ->update($productAttrImage);
                        }
                    }
                }
                foreach ($skuArrExist as $key1 => $val1) {

                    $id = $idArrExist[$key1];
                    $productAttrArrE['title'] = $nameArrExist[$key1];
                    $productAttrArrE['price'] = $priceArrExist[$key1];
                    $productAttrArrE['cut_price'] = $cutPriceArrExist[$key1];
                    $productAttrArrE['value'] = $valueArrExist[$key1];
                    $productAttrArrE['slug'] = SlugService::createSlug(ProductVariant::class, 'slug', $request->title . ' ' . $valueArrExist[$key1], ['unique' => false]);
                    $productAttrArrE['barcode'] = $barcodeArrExist[$key1];
                    $productAttrArrE['inventory'] = $inventoryArrExist[$key1];
                    $productAttrArrE['sku'] = $skuArrExist[$key1];
                    $productAttrArrE['weight'] = $weightArrExist[$key1] ?? 0;

                    DB::table('product_variants')
                        ->where('id', $id)
                        ->update($productAttrArrE);
                }
            }

            // Duplicate variant
            if (isset($request['exist_vari_value']) && $request->duplicate == 'yes') {
                $valueArrExist = $request['exist_vari_value'];
                $priceArrExist = $request['exist_vari_price'];
                $cutPriceArrExist = $request['exist_vari_cut_price'];
                $skuArrExist   = $request['exist_vari_sku'];
                $nameArrExist  = $request['exist_vari_name'];
                $barcodeArrExist   = $request['exist_vari_barcode'];
                $inventoryArrExist = $request['exist_vari_inventory'];
                $weightArrExist = $request['exist_vari_weight'] ?? 0;
                $imageArrExist = [];
                if ($request->hasFile('exist_vari_attr_images')) {
                    foreach ($request->file('exist_vari_attr_images') as $variantId => $image) {
                        if ($image) {
                            $variImageNameExist = time() . '_' . uniqid('', true) . '.' . $image->getClientOriginalExtension();
                            $variImagePathExist = $image->storeAs('product_images/main_images', $variImageNameExist, 'public');
                            $productAttrImage[] =  $variImagePathExist;
                        }
                    }
                    $imageArrExist = $productAttrImage;
                }
                foreach ($skuArrExist as $key1 => $val1) {
                    $productAttrArrE['product_id'] = $product->id;
                    $productAttrArrE['title'] = $nameArrExist[$key1];
                    $productAttrArrE['price'] = $priceArrExist[$key1];
                    $productAttrArrE['cut_price'] = $cutPriceArrExist[$key1];
                    $productAttrArrE['value'] = $valueArrExist[$key1];
                    $productAttrArrE['barcode'] = $barcodeArrExist[$key1];
                    $productAttrArrE['inventory'] = $inventoryArrExist[$key1];
                    $productAttrArrE['sku'] = $skuArrExist[$key1];
                    $productAttrArrE['weight'] = $weightArrExist[$key1] ?? 0;
                    $productAttrArrE['image'] = $imageArrExist[$key1] ?? 0;

                    DB::table('product_variants')->insert($productAttrArrE);
                }
            }
        }

        $message = "Product " . ($request->id ? "Updated" : "Saved") . " Successfully";
        return response()->json(['status' => 'success', 'message' => $message, 'data' => []]);
    }

    public function update_buy_limits(Request $request)
    {
        $user = auth()->user();
        $page_name = 'add_product';
        if (!view_permission($page_name)) {
            return redirect()->back();
        }

        $rules = [
            'id'  => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()]);
        }
        $product = Product::findOrFail($request->id);
        $product->update([
            'min_buy'       => $request->min_buy,
            'max_buy'       => $request->max_buy,
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
        $user = auth()->user();
        $page_name = 'add_product';
        if (!view_permission($page_name)) {
            return redirect()->back();
        }

        $rules = [
            'id'  => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()]);
        }
        $product = Product::findOrFail($request->id);
        $product->update([
            'status'       => $request->status,
        ]);

        $message = "Product status " . ($request->id ? "Updated" : "Saved") . " Successfully";
        return response()->json(['status' => 'success', 'message' => $message, 'data' => []]);
    }

    public function delete_featured_products(Request $request)
    {
        $product_id = $request->input('product_id');

        if (!$product_id) {
            return response()->json(['status' => 'error', 'message' => 'Product ID is required']);
        }

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
        $user = auth()->user();
        $page_name = 'prodcuts';
        if (!view_permission($page_name)) {
            return redirect()->back();
        }

        $data = [];
        if (isset($user->role) && $user->role == user_roles('1')) {
            $products = Product::with('category:id,name', 'sub_cat:id,name', 'child_cat:id,name')
                ->where('title', 'like', '%'.$request->string.'%')
                ->whereIn('status', [$this->status['Active']])
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
            'SalenPrice', 'Stock', 'Stock Status' , 'Weight', 'Min Buy', 'Max Buy', 'Combination Variants',
            'SKU', 'Barcode', 'Price', 'Category ID', 'Sub Category', 'Child Category',
            'Product Template', 'Question Category', 'Status', 'Created By', 'Updated By',
            'Created At', 'Updated At'
        ]);

        // Define base URL for slug and main image
        $baseUrl = 'https://onlinepharmacy-4u.co.uk';

        // Add product data
        foreach ($products as $product) {
            $csv->insertOne([
                $product->id,
                $product->title,
                $baseUrl . '/product/' . $product->slug, // Full URL for slug
                $product->short_desc,
                $product->desc,
                $baseUrl . '/storage/product_image' . $product->main_image, // Full URL for main image
                $product->price,
                $product->stock,
                $product->stock_status,
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

        // Prepare the CSV for download
        $csvData = $csv->toString();
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="products.csv"',
        ];

        return Response::make($csvData, 200, $headers);
    }
}
