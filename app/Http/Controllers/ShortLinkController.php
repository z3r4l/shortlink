<?php

namespace App\Http\Controllers;

use App\Models\ShortLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ShortLinkController extends Controller
{
    public function index(){
        $shortLinks = ShortLink::latest()->fastPaginate(10);
        return view('shorten', compact('shortLinks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'link' => 'required|url',
            'title' => 'required',
            'code' => [
                'required',
                function ($attribute, $value, $fail) {
                    // Validasi kustom: Mencegah spasi dan garis miring ("/") pada 'code'
                    if (strpos($value, ' ') !== false || strpos($value, '/') !== false) {
                        $fail('Code tidak boleh mengandung spasi atau garis miring ("/").');
                    }
                },
            ],
        ]);

        $input['title'] = $request->title;
        $input['link'] = $request->link;
        $input['code']  = $request->code;
        // Generate QR Code
        $qrCode = QrCode::format('png')
            ->size(200)
            ->errorCorrection('H')
            ->merge(public_path('images/logo.png'), 0.5, true) // Replace with the actual path to your logo
            ->generate($request->link);
        
        // Generate a unique filename for the QR code image
        $filename = 'qrcode_' . time() . '.png';
        
        // Store the QR code image in the storage
        Storage::put('public/qrcodes/' . $filename, $qrCode);
        
        // Save the filename in the database
        $input['qrcode'] = $filename;
        ShortLink::create($input);
        return redirect('short-link')->withSuccess('Link Berhasil Di Shorten');
    }

    public function destroy($id)
    {
        // Temukan entri ShortLink berdasarkan ID
        $shortLink = ShortLink::findOrFail($id);

        // Hapus file QR code dari penyimpanan
        Storage::delete('public/qrcodes/' . $shortLink->qrcode);

        // Hapus entri ShortLink dari database
        $shortLink->delete();

        return back()->withSuccess('Link Berhasil Dihapus');
    }
    public function shortenLink($code){
        $find = ShortLink::where('code', $code)->first();
        return redirect($find->link);
    }

    public function download($filename)
{
    // Misalnya, file-file Anda disimpan dalam direktori 'storage/app/public/files/'
    $filePath = 'public/qrcodes/' . $filename;

    return Storage::download($filePath);
   
}
}
