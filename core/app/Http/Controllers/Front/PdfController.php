<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    function showPdf($fileName)  {
        // Get path to existing PDF file      
        $path = storage_path('app/pdfs/'. $fileName . '.pdf');
        
    //    $pdfPath = public_path('files/document.pdf');

    return response()->file($path, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline'
     ]); 

    }

    function downloadPdf($fileName)  {
        // Get path to existing PDF file      
        $path = storage_path('app/pdfs/'. $fileName . '.pdf');
    //    $pdfPath = public_path('files/document.pdf');

    return response()->file($path, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'attachment'
     ]); 

    }
}