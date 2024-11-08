<?php

namespace App\Traits;

use App\Models\Category;

trait MenuCategoriesTrait
{
    protected $menu_categories;
    protected $status;
    protected $ENV;
    public function shareMenuCategories()
    {
        $this->status = config('constants.STATUS');
        $this->menu_categories = Category::where('status', 'Active')
            ->with(['subcategory' => function ($query) {
                $query->where('status', 'Active')
                    ->with(['childCategories' => function ($query) {
                        $query->where('status', 'Active');
                    }]);
            }])
            ->where('publish', 'Publish')
            ->latest('id')
            ->get()
            ->toArray();

        view()->share('menu_categories', $this->menu_categories);
        $this->ENV = env('PAYMENT_ENV', 'Live') ?? 'Live'; //1. Live, 2. Local.
    }
}
