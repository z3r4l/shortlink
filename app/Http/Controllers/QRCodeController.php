<?php

namespace App\Http\Controllers;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Http\Request;

class QRCodeController extends Controller
{
    public function generateQRCodeWithLogo()
    {
        $data = 'https://www.youtube.com/'; // Ganti dengan konten QR code yang diinginkan.
        $path = storage_path('app/public/qrcodes/tes.png'); // Lokasi penyimpanan QR code dengan logo.
        $logoPath = public_path('images/lks.png'); // Lokasi logo yang akan digunakan.
    
        QrCode::format('png')
             ->size(400) // Ukuran QR code
             ->errorCorrection('H')
             ->generate($data, $path);
    
        // Tambahkan logo ke QR code
        $qrCode = imagecreatefrompng($path);
        $logo = imagecreatefrompng($logoPath);
        $qrWidth = imagesx($qrCode);
        $qrHeight = imagesy($qrCode);
        $logoWidth = imagesx($logo);
        $logoHeight = imagesy($logo);
        $logoX = ($qrWidth - $logoWidth) / 2;
        $logoY = ($qrHeight - $logoHeight) / 2;
    
        imagecopy($qrCode, $logo, $logoX, $logoY, 0, 0, $logoWidth, $logoHeight);
    
        // Simpan QR code dengan logo
        imagepng($qrCode, $path);
        imagedestroy($qrCode);
    
        // Tampilkan QR code dengan logo
        return response()->file($path);
    }

private function addLogoToQRCode($qrCodePath)
{
    // Path logo Anda
    $logoPath = public_path('images/logoHMTI.svg');

    // Membuka gambar QR code dan logo
    $qrCode = imagecreatefromstring(file_get_contents(storage_path($qrCodePath)));
    $logo = imagecreatefrompng($logoPath);

    // Mendapatkan ukuran QR code dan logo
    $qrCodeWidth = imagesx($qrCode);
    $qrCodeHeight = imagesy($qrCode);
    $logoWidth = imagesx($logo);
    $logoHeight = imagesy($logo);

    // Menempatkan logo di tengah QR code
    $x = ($qrCodeWidth - $logoWidth) / 2;
    $y = ($qrCodeHeight - $logoHeight) / 2;

    // Menggabungkan QR code dan logo
    imagecopy($qrCode, $logo, $x, $y, 0, 0, $logoWidth, $logoHeight);

    // Simpan QR code dengan logo
    imagepng($qrCode, storage_path($qrCodePath));

    // Hapus gambar yang tidak digunakan
    imagedestroy($qrCode);
    imagedestroy($logo);
}
}
