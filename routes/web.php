<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\WebController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Web\ProductDetailsController;
use App\Http\Controllers\Web\ConsultancyController;
use App\Http\Controllers\Web\CategoriesController;
use App\Http\Controllers\Web\PaymentController;
use App\Http\Controllers\SiteMapController;
use App\Http\Controllers\ImportsController;
use App\Http\Controllers\web\ProductFeedController;

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

Route::post('/import-users', [ImportsController::class, 'importUsersData'])->name('import.users');
Route::post('/import-orders', [ImportsController::class, 'importOrdersData'])->name('import.orders');
Route::post('/import-orders-details', [ImportsController::class, 'importOrderDetailsData'])->name('import.ordersDetails');
Route::post('/import-shipping-details', [ImportsController::class, 'importShippingDetails'])->name('import.shippingDetails');
//Route::group(['middleware' => ['role:super_admin']], function () {
//    Route::get('/admin/dashboard', 'AdminController@dashboard');
//});

Route::get('/product-feed', [ProductFeedController::class, 'generateFeed']);

Route::get('/', [HomeController::class, 'index'])->name('web.index');
//Auth
Route::get('/sign-in', [AuthController::class, 'loginForm'])->name('sign_in_form');
Route::match(['get', 'post'],'/login', [AuthController::class, 'login'])->name('login');
Route::match(['get', 'post'], '/register', [AuthController::class, 'registration_form'])->name('register');
Route::match(['get', 'post'], '/registrationFrom', [AuthController::class, 'registerUser'])->name('web.user_register');
Route::match(['get', 'post'], '/logout', [AuthController::class, 'logout'])->name('web.logout');
Route::match(['get', 'post'], '/setting', [AuthController::class, 'profile_setting'])->name('web.profileSetting');
Route::match(['get', 'post'], '/profile-setting', [AuthController::class, 'profileSettingPage'])->name('web.profileSettingForm');
// forgot password
Route::match(['get', 'post'], '/forgotPassword', [AuthController::class, 'forgot_password'])->name('forgotPassword');
Route::match(['get', 'post'], '/sendOtp', [AuthController::class, 'send_otp'])->name('sendOtp');
Route::match(['get', 'post'], '/verifyOtp', [AuthController::class, 'verify_otp'])->name('verifyOtp');
Route::match(['get', 'post'], '/changePassword', [AuthController::class, 'change_password'])->name('changePassword');

//Dashboard
Route::get('/dashboard/details', [DashboardController::class, 'dashboard_details'])->name('dashboard.details');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('web.dashboard');
// Route::post('/import-users', [DashboardController::class, 'importUsersData'])->name('import.users');
//Product Details
Route::get('/shop', [ProductDetailsController::class, 'shop'])->name('shop');
Route::match(['get', 'post'], '/category/{main_category?}/{sub_category?}/{child_category?}', [ProductDetailsController::class, 'show_products'])->name('category.products');
Route::get('/product/{id:slug}', [ProductDetailsController::class, 'product_detail'])->name('web.product');
Route::post('/notify-me/{product}', [ProductDetailsController::class, 'notify'])->name('notify.me');
Route::match(['get', 'post'], '/productQuestion/{id}', [ProductDetailsController::class, 'product_question'])->name('web.productQuestion');
Route::get('/treatment', [ProductDetailsController::class, 'treatment'])->name('web.treatment');
// temporary route for generating slugs for existing products
Route::get('/generate_slug_existing', [ProductDetailsController::class, 'generateSlugExisting']);
Route::get('/generate_slug_variants_existing', [ProductDetailsController::class, 'generateSlugVariantsExisting']);

//consultation
Route::match(['get', 'post'], '/consultationForm', [ConsultancyController::class, 'consultationForm'])->name('web.consultationForm');
Route::match(['get', 'post'],'/idDocumentForm', [ConsultancyController::class, 'idDocumentForm'])->name('web.idDocumentForm');
Route::match(['get', 'post'], '/consultationStore', [ConsultancyController::class, 'consultationStore'])->name('web.consultationStore');
Route::match(['get', 'post'], '/transactionStore/', [ConsultancyController::class, 'transactionStore'])->name('web.transactionStore');

//Payment
Route::match(['get', 'post'], '/payment', [PaymentController::class, 'payment'])->name('payment');
Route::match(['get', 'post'], '/Completed-order', [PaymentController::class, 'completedOrder']);
Route::match(['get', 'post'], '/Unsuccessful-order', [PaymentController::class, 'unsuccessfulOrder']);
Route::match(['get', 'post'], '/thankYou', [PaymentController::class, 'thankYou'])->name('thankYou');
Route::match(['get', 'post'], '/transetionFail', [PaymentController::class, 'transectionFail'])->name('transetionFail');
Route::match(['get', 'post'], '/storeHumanForm', [PaymentController::class, 'storeHumanForm'])->name('storeHumanForm');
Route::match(['get', 'post'], '/successfullyRefunded', [PaymentController::class, 'successfullyRefunded'])->name('admin.successfullyRefunded');
Route::fallback([PaymentController::class, 'error404']);
include __DIR__ . '/admin.php';

//Web Controller
Route::get('/product_question', [WebController::class, 'product_question_new']);
Route::match(['get', 'post'], '/account', [WebController::class, 'account'])->name('web.account');
Route::match(['get', 'post'], '/wishlist', [WebController::class, 'wishlist'])->name('web.wishlist');
Route::match(['get', 'post'], '/howitworks', [WebController::class, 'howitworks'])->name('web.howitworks');
Route::match(['get', 'post'], '/faq', [WebController::class, 'faq'])->name('web.faq');

//cart
Route::get('/cart', [CartController::class, 'cart'])->name('web.view.cart');
Route::get('/checkout', [CartController::class, 'checkout'])->name('web.checkout');
Route::get('/destroy', [CartController::class, 'destroy'])->name('web.destroy');
Route::post('/reorder', [CartController::class, 'reorder'])->name('cart.reorder');
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('web.cart.add');
Route::post('/update-cart', [CartController::class, 'updateCart'])->name('web.cart.update');
Route::post('/delete-item', [CartController::class, 'deleteItem'])->name('web.cart.delete');
Route::get('/checkout/{id}', [CartController::class, 'checkout_id'])->name('web.checkout.id');

//Home Controller
Route::get('/questions_preview', [HomeController::class, 'questions_preview'])->name('web.questions_preview');
Route::get('/contact', [HomeController::class, 'contact_us'])->name('web.contact');
Route::get('/clinic', [HomeController::class, 'clinic'])->name('web.clinic');
// new pages added in home controller
Route::get('/contact', [HomeController::class, 'contact_us'])->name('web.contact');
Route::get('/help', [HomeController::class, 'help'])->name('web.help');
Route::get('/order_status', [HomeController::class, 'order_status'])->name('web.order_status');
Route::get('/delivery', [HomeController::class, 'delivery'])->name('web.delivery');
Route::get('/returns', [HomeController::class, 'returns'])->name('web.returns');
Route::get('/complaints', [HomeController::class, 'complaints'])->name('web.complaints');
Route::get('/blogs', [HomeController::class, 'blogs'])->name('web.blogs');
Route::get('/blog-details', [HomeController::class, 'blog_details'])->name('web.blog-details');
Route::get('/policy', [HomeController::class, 'policy'])->name('web.policy');
Route::get('/prescribers', [HomeController::class, 'prescribers'])->name('web.prescribers');
Route::get('/about', [HomeController::class, 'about'])->name('web.about');
Route::get('/work', [HomeController::class, 'howItWork'])->name('web.work');
Route::get('/product_information', [HomeController::class, 'product_information'])->name('web.product_information');
Route::get('/responsible_pharmacist', [HomeController::class, 'responsible_pharmacist'])->name('web.responsible_pharmacist');
Route::get('/modern_slavery_act', [HomeController::class, 'modern_slavery_act'])->name('web.modern_slavery_act');
Route::get('/opioid_policy', [HomeController::class, 'opioid_policy'])->name('web.opioid_policy');
Route::get('/privacy_and_cookies_policy', [HomeController::class, 'privacy_and_cookies_policy'])->name('web.privacy_and_cookies_policy');
Route::get('/terms_and_conditions', [HomeController::class, 'terms_and_conditions'])->name('web.terms_and_conditions');
Route::get('/acceptable_use_policy', [HomeController::class, 'acceptable_use_policy'])->name('web.acceptable_use_policy');
Route::get('/editorial_policy', [HomeController::class, 'editorial_policy'])->name('web.editorial_policy');
Route::get('/dispensing_frequencies', [HomeController::class, 'dispensing_frequencies'])->name('web.dispensing_frequencies');
Route::match(['get', 'post'],'/humanRequestForm', [HomeController::class, 'human_request_form'])->name('web.humanRequestForm');

Route::get('/email-template',function(){
return view('emails.order_confrimation');
});

//Sitemap
Route::get('/sitemap_index.xml', [SiteMapController::class, 'sitemap'])->name('sitemap');
Route::get('/page-sitemap.xml', [SiteMapController::class, 'pageSitemap'])->name('sitemap');
Route::get('/products-sitemap.xml', [SiteMapController::class, 'productSitemap'])->name('sitemap');
Route::get('/categories-sitemap.xml', [SiteMapController::class, 'categoriesSitemap'])->name('sitemap');

//Categories
Route::match(['get', 'post'], '/skincare', [CategoriesController::class, 'skincare'])->name('web.skincare');
Route::match(['get', 'post'], '/categorydetail', [CategoriesController::class, 'categoryDetail'])->name('web.categorydetail');
Route::match(['get', 'post'], '/diabetes', [CategoriesController::class, 'diabetes'])->name('web.diabetes');
Route::match(['get', 'post'], '/sleep', [CategoriesController::class, 'sleep'])->name('web.sleep');
Route::match(['get', 'post'], '/categories', [CategoriesController::class, 'categories'])->name('web.categories');
Route::match(['get', 'post'], '/search', [CategoriesController::class, 'search'])->name('web.search');
Route::get('/conditions', [CategoriesController::class, 'conditions'])->name('web.conditions');
Route::match(['get', 'post'], '/sleep', [CategoriesController::class, 'sleep'])->name('web.sleep');
Route::match(['get', 'post'], '/diabetes', [CategoriesController::class, 'diabetes'])->name('web.diabetes');
Route::match(['get', 'post'], '/skincare', [CategoriesController::class, 'skincare'])->name('web.skincare');
Route::get('/{main_category?}/{sub_category?}/{child_category?}', [CategoriesController::class, 'showCategories'])->name('web.collections');




