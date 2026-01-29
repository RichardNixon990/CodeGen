<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BarcodeController extends Controller
{
    public function Generate(Request $request)
    {
        $qr = null;
        if ($request->isMethod('post')) {
            $request->validate([
                'content' => 'required',
            ]);

            $qr = QrCode::size(300)->generate($request->input('content'));
        }
        return view('Generate', compact('qr'));
    }
}
