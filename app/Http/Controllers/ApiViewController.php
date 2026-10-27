<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ApiService;
class ApiViewController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __construct(private ApiService $apiService){}
    
    public function index(){
        //
        $data =  $this->apiService->getResponse();
        // dump($data);
    return view('welcome', $data);
    }
}
