<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    function showPdf()  {
        // Get path to existing PDF file      
        $path = storage_path('app/pdfs/doc.pdf');
    //    $pdfPath = public_path('files/document.pdf');

    return response()->file($path, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline'
     ]); 

    }
}
