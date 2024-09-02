<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\web\HomeController;
use App\Http\Controllers\web\WebController;
use App\Http\Controllers\web\CartController;
use App\Http\Controllers\Admin\DefualtController;
use App\Http\Controllers\GoogleMerchantController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('web.index');
Route::match(['get', 'post'], '/account', [WebController::class, 'account'])->name('web.account');
Route::match(['get', 'post'], '/login', [DefualtController::class, 'login'])->name('login');
Route::match(['get', 'post'], '/register', [DefualtController::class, 'registration_form'])->name('register');
Route::match(['get', 'post'], '/regisrationFrom', [DefualtController::class, 'user_register'])->name('web.user_register');
Route::match(['get', 'post'], '/logout', [DefualtController::class, 'logout'])->name('web.logout');

Route::get('/shop', [WebController::class, 'shop'])->name('shop');
Route::get('/product/{id:slug}', [WebController::class, 'product_detail'])->name('web.product');

Route::match(['get', 'post'], '/productQuestion/{id}', [WebController::class, 'product_question'])->name('web.productQuestion');
Route::match(['get', 'post'], '/consultationForm', [WebController::class, 'consultation_form'])->name('web.consultationForm');
Route::get('/idDocumentForm', [WebController::class, 'id_document_form'])->name('web.idDocumentForm');
Route::post('/idDocumentForm', [WebController::class, 'id_document_store'])->name('web.idDocumentForm');
Route::match(['get', 'post'], '/consultationStore', [WebController::class, 'consultation_store'])->name('web.consultationStore');
Route::match(['get', 'post'], '/transactionStore/', [WebController::class, 'transaction_store'])->name('web.transactionStore');
Route::get('/product_question', [WebController::class, 'product_question_new']);
Route::get('/questions_preview', [HomeController::class, 'questions_preview'])->name('web.questions_preview');

Route::get('/cart', [CartController::class, 'cart'])->name('web.view.cart');
Route::post('/reorder', [CartController::class, 'reorder'])->name('cart.reorder');
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('web.cart.add');
Route::post('/update-cart', [CartController::class, 'updateCart'])->name('web.cart.update');
Route::post('/delete-item', [CartController::class, 'deleteItem'])->name('web.cart.delete');
Route::get('/checkout', [CartController::class, 'checkout'])->name('web.checkout');
Route::get('/checkout/{id}', [CartController::class, 'checkout_id'])->name('web.checkout.id');

Route::get('/aboutUs', [HomeController::class, 'about_us'])->name('web.aboutUs');
Route::match(['get', 'post'], '/wishlist', [WebController::class, 'wishlist'])->name('web.wishlist');
Route::match(['get', 'post'], '/howitworks', [WebController::class, 'howitworks'])->name('web.howitworks');
Route::match(['get', 'post'], '/faq', [WebController::class, 'faq'])->name('web.faq');
Route::get('/faqs', [WebController::class, 'faqs'])->name('faqs');
Route::get('/contact', [HomeController::class, 'contact_us'])->name('web.contact');
Route::get('/clinic', [HomeController::class, 'clinic'])->name('web.clinic');

Route::match(['get', 'post'], '/payment', [WebController::class, 'payment'])->name('payment');
Route::match(['get', 'post'], '/Completed-order', [WebController::class, 'completed_order']);
Route::match(['get', 'post'], '/thankYou', [WebController::class, 'thank_you'])->name('thankYou');
Route::match(['get', 'post'], '/successfullyRefunded', [WebController::class, 'successfully_refunded'])->name('admin.successfullyRefunded');
Route::match(['get', 'post'], '/transetionFail', [WebController::class, 'transetion_fail'])->name('transetionFail');
Route::match(['get', 'post'], '/Unsuccessful-order', [WebController::class, 'unsuccessful_order']);

Route::match(['get', 'post'], '/search', [WebController::class, 'search'])->name('web.search');
Route::get('/product_question', [WebController::class, 'product_question_new']);


// working routes

Route::get('/questions_preview', [HomeController::class, 'questions_preview'])->name('web.questions_preview');

Route::get('/', [HomeController::class, 'index'])->name('web.index');
Route::match(['get', 'post'], '/consultationForm', [WebController::class, 'consultation_form'])->name('web.consultationForm');
Route::match(['get', 'post'], '/consultationStore', [WebController::class, 'consultation_store'])->name('web.consultationStore');
Route::match(['get', 'post'], '/account', [WebController::class, 'account'])->name('web.account');
Route::match(['get', 'post'], '/wishlist', [WebController::class, 'wishlist'])->name('web.wishlist');
Route::match(['get', 'post'], '/faq', [WebController::class, 'faq'])->name('web.faq');
Route::match(['get', 'post'], '/categories', [WebController::class, 'categories'])->name('web.categories');
Route::match(['get', 'post'], '/categorydetail', [WebController::class, 'categorydetail'])->name('web.categorydetail');
Route::match(['get', 'post'], '/skincare', [WebController::class, 'skincare'])->name('web.skincare');
Route::match(['get', 'post'], '/diabetes', [WebController::class, 'diabetes'])->name('web.diabetes');
Route::match(['get', 'post'], '/sleep', [WebController::class, 'sleep'])->name('web.sleep');

//cart
Route::get('/cart', [CartController::class, 'cart'])->name('web.view.cart');
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('web.cart.add');
Route::post('/update-cart', [CartController::class, 'updateCart'])->name('web.cart.update');
Route::get('/checkout', [CartController::class, 'checkout'])->name('web.checkout');
Route::get('/destroy', [CartController::class, 'destroy'])->name('web.destroy');

// new pages added in home controller
Route::get('/faqs', [WebController::class, 'faqs'])->name('faqs');
Route::get('/contact', [HomeController::class, 'contact_us'])->name('web.contact');
Route::get('/help', [HomeController::class, 'help'])->name('web.help');
Route::get('/order_status', [HomeController::class, 'order_status'])->name('web.order_status');
Route::get('/delivery', [HomeController::class, 'delivery'])->name('web.delivery');
Route::get('/returns', [HomeController::class, 'returns'])->name('web.returns');
Route::get('/complaints', [HomeController::class, 'complaints'])->name('web.complaints');
Route::get('/complaints', [HomeController::class, 'complaints'])->name('web.complaints');
Route::get('/blogs', [HomeController::class, 'blogs'])->name('web.blogs');
Route::get('/blog-details', [HomeController::class, 'blog_details'])->name('web.blog-details');
Route::get('/policy', [HomeController::class, 'policy'])->name('web.policy');
Route::get('/prescribers', [HomeController::class, 'prescribers'])->name('web.prescribers');
Route::get('/about', [HomeController::class, 'about'])->name('web.about');
Route::get('/work', [HomeController::class, 'how_it_work'])->name('web.work');
Route::get('/product_information', [HomeController::class, 'product_information'])->name('web.product_information');
Route::get('/responsible_pharmacist', [HomeController::class, 'responsible_pharmacist'])->name('web.responsible_pharmacist');
Route::get('/modern_slavery_act', [HomeController::class, 'modern_slavery_act'])->name('web.modern_slavery_act');
Route::get('/opioid_policy', [HomeController::class, 'opioid_policy'])->name('web.opioid_policy');
Route::get('/privacy_and_cookies_policy', [HomeController::class, 'privacy_and_cookies_policy'])->name('web.privacy_and_cookies_policy');
Route::get('/terms_and_conditions', [HomeController::class, 'terms_and_conditions'])->name('web.terms_and_conditions');
Route::get('/acceptable_use_policy', [HomeController::class, 'acceptable_use_policy'])->name('web.acceptable_use_policy');
Route::get('/editorial_policy', [HomeController::class, 'editorial_policy'])->name('web.editorial_policy');
Route::get('/dispensing_frequencies', [HomeController::class, 'dispensing_frequencies'])->name('web.dispensing_frequencies');
Route::get('/product_information', [HomeController::class, 'product_information'])->name('web.product_information');

Route::get('/treatment', [WebController::class, 'treatment'])->name('web.treatment');
Route::get('/conditions', [WebController::class, 'conditions'])->name('web.conditions');

// temporary route for generating slugs for existing products
Route::get('/generate_slug_existing', [WebController::class, 'generate_slug_existing']);
Route::get('/generate_slug_variants_existing', [WebController::class, 'generate_slug_variants_existing']);

// forgot password
Route::match(['get', 'post'], '/forgotPassword', [DefualtController::class, 'forgot_password'])->name('forgotPassword');
Route::match(['get', 'post'], '/sendOtp', [DefualtController::class, 'send_otp'])->name('sendOtp');
Route::match(['get', 'post'], '/verifyOtp', [DefualtController::class, 'verify_otp'])->name('verifyOtp');
Route::match(['get', 'post'], '/changePassword', [DefualtController::class, 'change_password'])->name('changePassword');


Route::get('/dashboard/details', [DefualtController::class, 'dashboard_details'])->name('dashboard.details');
Route::match(['get', 'post'], '/storeHumanForm', [WebController::class, 'store_human_form'])->name('storeHumanForm');
Route::match(['get', 'post'],'/humanRequestForm', [HomeController::class, 'human_request_form'])->name('web.humanRequestForm');

Route::get('/email-template',function(){
return view('emails.order_confrimation');
});

Route::fallback([WebController::class, 'error_404']);
include __DIR__ . '/admin.php';

Route::get('/sitemap_index.xml', [WebController::class, 'sitemap'])->name('sitemap');
Route::get('/page-sitemap.xml', [WebController::class, 'pagesitemap'])->name('sitemap');
Route::get('/categories-sitemap.xml', [WebController::class, 'categoriessitemap'])->name('sitemap');
Route::get('/products-sitemap.xml', [WebController::class, 'productsitemap'])->name('sitemap');

Route::match(['get', 'post'], '/categories', [WebController::class, 'categories'])->name('web.categories');
Route::match(['get', 'post'], '/sleep', [WebController::class, 'sleep'])->name('web.sleep');
Route::match(['get', 'post'], '/category/{main_category?}/{sub_category?}/{child_category?}', [WebController::class, 'show_products'])->name('category.products');
Route::match(['get', 'post'], '/diabetes', [WebController::class, 'diabetes'])->name('web.diabetes');
Route::match(['get', 'post'], '/skincare', [WebController::class, 'skincare'])->name('web.skincare');
Route::match(['get', 'post'], '/categorydetail', [WebController::class, 'categorydetail'])->name('web.categorydetail');
Route::get('/{main_category?}/{sub_category?}/{child_category?}', [WebController::class, 'show_categories'])->name('web.collections');


Route::get('/google-products', [GoogleMerchantController::class, 'listProducts']);



