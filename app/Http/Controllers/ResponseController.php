<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ResponseController extends Controller
{
    public function response(Request $request):Response
    {
        return response("Hello Response");
    }

    public function header(Request $request):Response
    {
     $body = [
        'firstName'=> 'Ivriel',
        'lastName'=> 'Gunawan'
     ];
     return response(json_encode($body),200)
     ->header('Content-Type','application/json')
     ->withHeaders([
        'Author'=>'Ivriel',
        'App'=> 'Belajar Laravel'
     ]);
    }

     public function responseView(Request $request):Response
    {
        return response()
        ->view('hello',['name'=>'Ivriel']) // view blade php
        ;
    }

     public function responseJson(Request $request):JsonResponse
    {
        $body= [
        'firstName'=> 'Ivriel',
        'lastName'=> 'Gunawan'
        ];
        return response()->json($body);
    }

    public function responseFile(Request $request):BinaryFileResponse
    {
        return response()->file(storage_path('app/public/pictures/kisspng-cascading-style-sheets-h.jpg'));
    }

     public function responseDownload(Request $request):BinaryFileResponse
    {
        return response()->download(storage_path('app/public/pictures/kisspng-cascading-style-sheets-h.jpg'));
    }

}
