<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class SiteMapController extends Controller
{
    public function generateSitemap()
    {
        // Create a new SimpleXMLElement object to build the XML structure
        $sitemap = new \SimpleXMLElement('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"/>');
        
        // Define the static URLs you want to include in the sitemap
        $urls = [
            route('web.index'),
            route('web.contact'),
            route('web.clinic'),
            route('web.order_status'),
            route('web.delivery'),
            route('web.returns'),
            route('web.complaints'),
            route('web.blogs'),
            route('web.policy'),
            route('web.about'),
            route('web.work'),
            route('web.product_information'),
            route('web.responsible_pharmacist'),
            route('web.modern_slavery_act'),
            route('web.privacy_and_cookies_policy'),
            route('web.terms_and_conditions'),
            route('web.acceptable_use_policy'),
            route('web.editorial_policy'),
            route('web.dispensing_frequencies'),
        ];

        // Loop through dynamic routes like products and categories
        $products = \App\Models\Product::all(); // Assuming you have a Product model
        foreach ($products as $product) {
            $urls[] = route('web.product', ['id' => $product->slug]);
        }

        // Add each URL to the sitemap XML
        foreach ($urls as $url) {
            $urlElement = $sitemap->addChild('url');
            $urlElement->addChild('loc', $url);
            $urlElement->addChild('lastmod', now()->toAtomString());
            $urlElement->addChild('changefreq', 'weekly');
            $urlElement->addChild('priority', '0.8');
        }

        // Return the sitemap as XML response
        return response($sitemap->asXML(), 200)
                ->header('Content-Type', 'application/xml');
    }
}
