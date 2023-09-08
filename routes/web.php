<?php

use App\Http\Controllers\QRCodeController;
use App\Http\Controllers\ShortLinkController;
use Illuminate\Support\Facades\Route;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('qr-code-g', function () {
    QrCode::size(500)
            ->format('png')
            ->generate('https://www.youtube.com/results?search_query=tutorial+membuat+qr+code+laravel', public_path('images/qrcode.png'));
  return view('qrCode');
});
Route::get('/generate-qr-code-with-logo', [QRCodeController::class, 'generateQRCodeWithLogo']);


// Route Shortlink
Route::get('short-link', [ShortLinkController::class, 'index']);
Route::post('short-link', [ShortLinkController::class, 'store'])->name('generate.shorten.link.post');
Route::delete('short-links/destroy/{id}', [ShortLinkController::class, 'destroy'])->name('shorten.link.destroy');
Route::get('{code}', [ShortLinkController::class, 'shortenLink'])->name('shorten.link');
Route::get('download/{filename}', [ShortLinkController::class, 'download'])->name('qr.download');


