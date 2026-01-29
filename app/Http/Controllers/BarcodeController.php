<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BarcodeController extends Controller
{
    public function index(){
        return view('Generate');
    }
    public function Generate(Request $request){
        $request->validate([
            'url' => 'required|url',
        ]);

        $qr = QrCode::size(300)->generate($request->input('url'));
        return view('Generate', compact('qr'));
    }
}
