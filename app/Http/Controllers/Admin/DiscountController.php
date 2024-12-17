<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AdminDashboard\StoreDiscountRequest;
use App\Http\Requests\UpdateDiscountRequest;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Discount;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ChildCategory;
use App\Traits\UserStatusTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class DiscountController extends Controller
{
    use UserStatusTrait;

    public function discount()
    {
        // Fetch all discounts from the database
        $discounts = Discount::latest()->get();

        // Return a view with the discounts
        return view('admin.pages.discount', compact('discounts'));
    }

    public function add_discount()
    {
        $data['user'] = $this->getAuthUser();
        $this->authorize('orders_created');
        
    
        // Fetch products with variants (this part stays the same)
        $data['products'] = Product::with('variants')
            ->where('status', $this->getUserStatus('Active'))
            ->latest('id')
            ->get()
            ->sortBy('title')
            ->values()
            ->keyBy('id')
            ->toArray();
    
        foreach ($data['products'] as $key => $product) {
            if ($product['variants']) {
                $data['variants'][$product['id']] = $product['variants'];
            }
        }
    
        // Fetch active users (this part stays the same)
        $data['users'] = User::where('status', $this->getUserStatus('Active'))
            ->whereHas('roles', function ($query) {
                $query->where('name', 'user');
            })
            ->with(['address', 'profile'])
            ->orderBy('name')
            ->get()
            ->keyBy('id')
            ->toArray();
    
        foreach ($data['users'] as &$user) {
            $user['phone'] = $user['profile']['phone'] ?? null;
        }
    
        // Fetch categories with sub-categories and child categories
        $data['categories'] = Category::with(['subCategory.childCategories'])
            ->where('status', 'Active')  // You can add more conditions here
            ->orderBy('name')
            ->get()
            ->keyBy('id'); // Key categories by their ID for easy access
    
        return view('admin.pages.add_discount', $data);
    }

    public function getProductVariants(Request $request)
    {
        // Fetch the variants based on the product_id from the product_variant table
        $variants = ProductVariant::where('product_id', $request->product_id)->get();
        
        // Log the result for debugging
        \Log::info('Product Variants:', $variants->toArray());
        
        if ($variants->isNotEmpty()) {
            return response()->json($variants);
        }
        
        return response()->json([]);
    }
    


    public function getSubCategories(Request $request)
    {
        $subCategories = SubCategory::where('category_id', $request->category_id)->get();
    
        // Log the query result for debugging
        \Log::info('SubCategories:', $subCategories->toArray());
    
        if ($subCategories->isNotEmpty()) {
            return response()->json($subCategories);
        }
    
        return response()->json([]);
    }
    


    public function getChildCategories(Request $request)
    {
        $childCategories = ChildCategory::where('sub_category_id', $request->sub_category_id)->get();
        
        if ($childCategories->isNotEmpty()) {
            return response()->json($childCategories); // Return the child categories for the selected sub-category
        }
    
        return response()->json([]); // Return an empty array if no child categories found
    }
    

    public function store(StoreDiscountRequest $request)
    {
        // Check if product-based or category-based selection is made
        $selectionType = $request->input('selection_type');
        
        // Determine values based on the selection type
        $productId = $selectionType === 'product' ? $request->input('product_id') : null;
        $variantId = $selectionType === 'product' ? $request->input('variant_id') : null;
        $categoryId = $selectionType === 'category' ? $request->input('category_id') : null;
        $subCategoryId = $selectionType === 'category' ? $request->input('sub_category_id') : null;
        $childCategoryId = $selectionType === 'category' ? $request->input('child_category_id') : null;
    
        // Validate that product_id or category_id is provided
        if ($selectionType === 'product' && !$productId) {
            return response()->json(['message' => 'Product ID is required'], 400);
        }
    
        if ($selectionType === 'category' && (!$categoryId && !$subCategoryId && !$childCategoryId)) {
            return response()->json(['message' => 'Category, Subcategory, and Childcategory are required'], 400);
        }
    
        // Get the existing discount based on the code or ID
        $discountId = $request->input('discount_id');
        $discount = Discount::updateOrCreate(
            ['id' => $discountId], // If $discountId exists, update the discount, otherwise create a new one
            [
                'code' => $request->input('code'),
                'discount_type' => $request->input('discount_type'),
                'value' => $request->input('value', null),
                'selection_type' => $request->input('selection_type'),
                'min_purchase_amount' => $request->input('min_purchase_amount'),
                'product_id' => $productId,
                'variant_id' => $variantId,
                'category_id' => $categoryId,
                'subcategory_id' => $subCategoryId,
                'childcategory_id' => $childCategoryId,
                'start_date' => $request->input('start_date'),
                'end_date' => $request->has('end_date_toggle') ? $request->input('end_date') : null,
                'start_time' => $request->input('start_time'),
                'end_time' => $request->input('end_time'),
                'max_usage' => $request->input('max_usage'),
                'max_usage_per_user' => $request->input('max_usage_per_user'),
                'is_active' => $request->has('is_active') ? $request->input('is_active') : true,
            ]
        );
    
        return redirect()->route('admin.Discount')
            ->with('success', 'Discount Code ' . ($discountId ? 'Updated' : 'Created') . ' Successfully');
    }


    public function edit($discountId = null)
    {
        $discount = $discountId ? Discount::find($discountId) : new Discount();
        return view('admin.pages.add_discount', compact('discount'));
    }
    

    

//     public function update(UpdateDiscountRequest $request, $id)
// {
//     $discount = Discount::findOrFail($id);

//     // Similar logic for updating the discount as in the store method
//     $selectionType = $request->input('selection_type');
//     $productId = $selectionType === 'product' ? $request->input('product_id') : null;
//     $variantId = $selectionType === 'product' ? $request->input('variant_id') : null;
//     $categoryId = $selectionType === 'category' ? $request->input('category_id') : null;
//     $subCategoryId = $selectionType === 'category' ? $request->input('sub_category_id') : null;
//     $childCategoryId = $selectionType === 'category' ? $request->input('child_category_id') : null;

//     // Update the discount in the database
//     $discount->update([
//         'code' => $request->input('code'),
//         'discount_type' => $request->input('discount_type'),
//         'value' => $request->input('value', null),
//         'selection_type' => $request->input('selection_type'),
//         'min_purchase_amount' => $request->input('min_purchase_amount'),
//         'product_id' => $productId,
//         'variant_id' => $variantId,
//         'category_id' => $categoryId,
//         'subcategory_id' => $subCategoryId,
//         'childcategory_id' => $childCategoryId,
//         'start_date' => $request->input('start_date'),
//         'end_date' => $request->has('end_date_toggle') ? $request->input('end_date') : null,
//         'start_time' => $request->input('start_time'),
//         'end_time' => $request->input('end_time'),
//         'max_usage' => $request->input('max_usage'),
//         'max_usage_per_user' => $request->input('max_usage_per_user'),
//         'is_active' => $request->has('is_active') ? $request->input('is_active') : true,
//     ]);

//     return redirect()->route('admin.Discount')
//         ->with('success', 'Discount Code Updated Successfully');
// }


    
}
