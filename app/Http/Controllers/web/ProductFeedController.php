<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Response;

class ProductFeedController extends Controller
{
    public function generateFeed()
    {
        $products = Product::all(); // Fetch all products

        $xml = new \SimpleXMLElement('<?xml version="1.0"?><rss xmlns:g="http://base.google.com/ns/1.0" version="2.0"></rss>');
        $channel = $xml->addChild('channel');
        $channel->addChild('title', 'Your Store Name Product Feed');
        $channel->addChild('link', url('/'));
        $channel->addChild('description', 'Product feed for Google Merchant Center');

        foreach ($products as $product) {
            $item = $channel->addChild('item');
            $item->addChild('g:id', $product->id);
            $item->addChild('g:title', htmlspecialchars($product->title));
            $item->addChild('g:description', htmlspecialchars($product->short_desc));
            $item->addChild('g:link', url('/product/' . $product->slug));
            $item->addChild('g:image_link', asset($product->main_image));
            $item->addChild('g:price', $product->price . ' USD');
            $item->addChild('g:availability', $product->stock > 0 ? 'in stock' : 'out of stock');
        }

        return Response::make($xml->asXML(), 200)->header('Content-Type', 'application/xml');
    }
}
