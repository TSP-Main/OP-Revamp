<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ChildCategory;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\MenuCategoriesTrait;

class CategoriesController extends Controller
{
    use MenuCategoriesTrait;

    public function showCategories(Request $request, $category = null, $sub_category = null, $child_category = null)
    {
        // use with route collections
        $this->shareMenuCategories();
        $level = '';
        $category_id = $sub_category_id = $child_category_id = null;
        if ($category && $sub_category && $child_category) {
            $level = 'child';
            $child_category_id = ChildCategory::where(['slug' => $child_category, 'status' => 'Active'])->where('status', 'Active')->first();
        } else if ($category && $sub_category && !$child_category) {
            $level = 'sub';
            $sub_category_id = SubCategory::where(['slug' => $sub_category, 'status' => 'Active'])->first();
        } else if ($category && !$sub_category && !$child_category) {
            $level = 'main';
            $category_id = Category::where(['slug' => $category, 'status' => 'Active'])->first();
        }

        if ($category_id || $sub_category_id || $child_category_id) {
            $query = Product::query()->where('status', $this->status['Active']);
            switch ($level) {
                case 'main':
                    $data['main_category'] = Category::where(['slug' => $category, 'status' => 'Active'])->first();
                    $data['categories'] = SubCategory::where(['category_id' => $data['main_category']->id, 'status' => 'Active'])->get()->toArray();
                    $data['image'] = $data['main_category']['image'];
                    $data['category_name'] = $data['main_category']['name'];
                    $data['category_desc'] = $data['main_category']['desc'];
                    $data['main_slug'] = $data['main_category']['slug'];
                    // $data['products'] = Product::where(['category_id' => $data['main_category']->id])->paginate(21);
                    $query->where(['category_id' => $data['main_category']->id]);
                    $data['is_product'] = false;
                    break;
                case 'sub':
                    $data['main_category'] = Category::where(['slug' => $category, 'status' => 'Active'])->first();
                    $data['sub_category'] = SubCategory::where(['slug' => $sub_category, 'status' => 'Active'])->first();
                    $data['categories'] = ChildCategory::where(['sub_category_id' => $data['sub_category']->id, 'status' => 'Active'])->get()->toArray();
                    $data['image'] = $data['sub_category']['image'];
                    $data['category_name'] = $data['sub_category']['name'];
                    $data['category_desc'] = $data['sub_category']['desc'];
                    $data['main_slug'] = $data['main_category']['slug'];
                    $data['sub_slug'] = $data['sub_category']['slug'];
                    // $data['products'] = Product::where(['sub_category' => $data['sub_category']->id])->paginate(21);
                    $query->where(['sub_category' => $data['sub_category']->id]);
                    $data['is_product'] = true;
                    break;
                case 'child':
                    $data['category'] = ChildCategory::where(['slug', $child_category, 'status' => 'Active'])->first();
                    $data['is_product'] = true;
                    break;
                default:
                    $products = Product::where('status', $this->status['Active'])->paginate(21);
            }

            if ($request->has('sort')) {
                if ($request->sort === 'price_low_high') {
                    $query->orderBy('price');
                } elseif ($request->sort === 'price_high_low') {
                    $query->orderByDesc('price');
                } elseif ($request->sort === 'newest') {
                    $query->orderByDesc('created_at');
                }
            }
            $data['products'] = $query->paginate(21);

            return view('web.pages.collections', $data);
        } else {
            return view('web.pages.404');
        }
    }

    public function categories()
    {
        $data['user'] = auth()->user() ?? [];
        return view('web.pages.categories', $data);
    }
    public function categoryDetail()
    {
        $data['user'] = auth()->user() ?? [];
        return view('web.pages.categorydetail', $data);
    }
    public function skincare()
    {
        $data['user'] = auth()->user() ?? [];
        $sub_category_id = SubCategory::where('slug', 'skin-care')->first()->id;
        $data['products'] = Product::where(['sub_category' => $sub_category_id, 'status' => $this->status['Active']])->get();
        return view('web.pages.skincare', $data);
    }

    public function diabetes()
    {
        $data['user'] = auth()->user() ?? [];
        $sub_category_id = SubCategory::where('slug', 'diabetes')->first()->id;
        $data['products'] = Product::where(['sub_category' => $sub_category_id])->where('status', $this->status['Active'])->get();
        return view('web.pages.diabetes', $data);
    }

    public function sleep()
    {
        $data['user'] = auth()->user() ?? [];
        $sub_category_id = SubCategory::where('slug', 'sleep')->first()->id;
        $data['products'] = Product::where('sub_category', $sub_category_id)->where('status', $this->status['Active'])->get();
        return view('web.pages.sleep', $data);
    }

    public function search(Request $request)
    {
        $data['string'] = $request->q;
        $category_id = Category::where('name', 'like', '%' . $data['string'] . '%')->pluck('id');
        $subCategory_id = SubCategory::where('name', 'like', '%' . $data['string'] . '%')->pluck('id');
        $childCategory_id = ChildCategory::where('name', 'like', '%' . $data['string'] . '%')->pluck('id');

        $data['products'] = Product::where(['status' => $this->status['Active']])->where('title', 'like', '%' . $data['string'] . '%')
            ->when(!$category_id->isEmpty(), function ($query) use ($category_id) {
                $query->orWhereIn('category_id', $category_id);
            })
            ->when(!$subCategory_id->isEmpty(), function ($query) use ($subCategory_id) {
                $query->orWhereIn('sub_category', $subCategory_id);
            })
            ->when(!$childCategory_id->isEmpty(), function ($query) use ($childCategory_id) {
                $query->orWhereIn('child_category', $childCategory_id);
            })
            ->paginate(20);

        $data['total'] = $data['products']->total();
        $data['currentPage'] = $data['products']->count();

        return view('web.pages.search', $data);
    }

    public function get_category_slug($product_id)
    {
        $product = Product::find($product_id);
        $category = $product->category_id;
        $sub_category = $product->sub_category;
        $child_category = $product->child_category;
        $level = '';
        if ($category && $sub_category && $child_category) {
            $level = 'child';
        } else if ($category && $sub_category && !$child_category) {
            $level = 'sub';
        } else if ($category && !$sub_category && !$child_category) {
            $level = 'main';
        }

        switch ($level) {
            case 'main':
                $slug['main_category'] = Category::where(['id' => $category])->pluck('slug');
                break;
            case 'sub':
                $slug['sub_category'] = SubCategory::where(['id' => $sub_category])->pluck('slug');;
                break;
            case 'child':
                $slug['child_category'] = ChildCategory::where(['id' => $child_category])->pluck('slug');;
                break;
        }

        return $slug ?? NULL;
    }

    public function conditions(Request $request)
    {
        $this->shareMenuCategories();
        $ranges = [
            'a-e' => ['a', 'b', 'c', 'd', 'e'],
            'f-j' => ['f', 'g', 'h', 'i', 'j'],
            'k-o' => ['k', 'l', 'm', 'n', 'o'],
            'p-t' => ['p', 'q', 'r', 's', 't'],
            'u-z' => ['u', 'v', 'w', 'x', 'y', 'z'],
        ];

        $letters = $request->t ? $ranges[$request->t] : $ranges['a-e'];

        $categories = Category::select('name', 'slug', 'image', 'slug AS url')
            ->where('status', 'Active')
            ->where(function ($query) use ($letters) {
                foreach ($letters as $letter) {
                    $query->orWhere('name', 'like', $letter . '%');
                }
            })
            ->whereHas('products');

        $subCategories = SubCategory::select(
            'sub_categories.name',
            'sub_categories.slug',
            'sub_categories.image',
            DB::raw("CONCAT(categories.slug, '/', sub_categories.slug) AS url")
        )
            ->leftJoin('categories', 'sub_categories.category_id', '=', 'categories.id')
            ->where('sub_categories.status', 'Active')
            ->where(function ($query) use ($letters) {
                foreach ($letters as $letter) {
                    $query->orWhere('sub_categories.name', 'like', $letter . '%');
                }
            })
            ->whereHas('products')
            ->with('category');

        $childCategories = ChildCategory::select(
            'child_categories.name',
            'child_categories.slug',
            'child_categories.image',
            DB::raw("CONCAT(categories.slug, '/', sub_categories.slug, '/', child_categories.slug) AS url")
        )
            ->leftJoin('sub_categories', 'child_categories.sub_category_id', '=', 'sub_categories.id')
            ->leftJoin('categories', 'sub_categories.category_id', '=', 'categories.id')
            ->where('child_categories.status', 'Active')
            ->where(function ($query) use ($letters) {
                foreach ($letters as $letter) {
                    $query->orWhere('child_categories.name', 'like', $letter . '%');
                }
            })
            ->whereHas('products');

        $data['conditions'] = $categories->union($subCategories)->union($childCategories)->orderBy('name')->get();
        $data['range'] = $request->t ?? 'a-e';

        return view('web.pages.conditions', $data);
    }
}
