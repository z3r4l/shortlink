<?php

namespace App\Http\Controllers;

use App\Models\ShortLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ShortLinkController extends Controller
{
    public function index(){
        $shortLinks = ShortLink::latest()->get();
        return view('shorten', compact('shortLinks'));
    }

    public function store(Request $request)
{
    $request->validate([
        'link' => 'required|url',
        'title' => 'required',
    ]);

    $input['title'] = $request->title;
    $input['link'] = $request->link;
    $input['code']  = $request->code;
    // Generate QR Code
    $qrCode = QrCode::format('png')
        ->size(200)
        ->errorCorrection('H')
        ->merge(public_path('images/logoNextup.jpg'), 0.5, true) // Replace with the actual path to your logo
        ->generate($request->link);
    
    // Generate a unique filename for the QR code image
    $filename = 'qrcode_' . time() . '.png';
    
    // Store the QR code image in the storage
    Storage::put('public/qrcodes/' . $filename, $qrCode);
    
    // Save the filename in the database
    $input['qrcode'] = $filename;
    ShortLink::create($input);
    return redirect('generate-short-link')->withSuccess('Link Berhasil Di Shorten');
}

    public function shortenLink($code){
        $find = ShortLink::where('code', $code)->first();
        return redirect($find->link);
    }

    public function download($filename)
{
    // Misalnya, file-file Anda disimpan dalam direktori 'storage/app/public/files/'
    $filePath = 'public/qrcodes/' . $filename;
    // dd($filename);
    return Storage::download($filePath);
    // if (Storage::exists($filePath)) {
    //     return response()->download($filename);
    // } else {
    //     abort(404, 'File not found');
    // }
}
}
