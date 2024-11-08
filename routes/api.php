<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\api\SystemUserManagmentController;
use App\Http\Controllers\Admin\api\PdfGeneratorController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {

    Route::match(['post','get'],'/userStore', [SystemUserManagmentController::class, 'user_store']);
        
    Route::match(['post','get'],'/deleteUsers', [SystemUserManagmentController::class, 'deleteUsers']);

});
// Route::middleware('auth:sanctum')->get('/makeCurlRequest', [SystemUserManagmentController::class, 'makeCurlRequest']);

Route::match(['get', 'post'], '/generatepdf', [PdfGeneratorController::class, 'index'])->name('pdf.creator');
Route::match(['get', 'post'], '/bulkPrint', [PdfGeneratorController::class, 'order_bulk_print'])->name('pdf.bulkPrint');
Route::match(['get', 'post'], '/createGpaLetters', [PdfGeneratorController::class, 'gpa_letter'])->name('pdf.createGpaLetters');
Route::match(['get', 'post'], '/sendGpaLetters', [PdfGeneratorController::class, 'send_gpa_letter'])->name('pdf.sendGpaLetters');
