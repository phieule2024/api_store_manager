<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRController extends Controller
{
    public function generateQRCode()
    {
        $url = 'https://www.youtube.com/';

        return QrCode::size(250)->generate($url);
    }

    public function showScanQRCodeForm()
    {
        return view('scan-qr-code');
    }

}
