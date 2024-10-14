<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SiteMapController extends Controller
{
    public function sitemap()
    {
        return view('web.pages.sitemap');
    }
    public function pageSitemap()
    {
        return view('web.pages.pagesitemap');
    }
    public function productSitemap()
    {
        return view('web.pages.productsitemap');
    }
    public function categoriesSitemap()
    {
        return view('web.pages.categoriessitemap');
    }
}
