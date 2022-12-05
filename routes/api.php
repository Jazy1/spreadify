<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get("/musha", function (){
    $response = Http::dd()->get("https://api.sandbox.ebay.com");
    
    return $response->body();
});

Route::get("auth/ebay/get-application-access-token", function(Request $request){
    
    $link = "https://api.sandbox.ebay.com/identity/v1/oauth2/token";
    $clientId = env("EBAY_CLIENT_ID");
    $clientSecert = env("EBAY_CLIENT_SECERT");
    $scope = "https://api.ebay.com/oauth/api_scope";

    $b64 = base64_encode($clientId.":".$clientSecert);
    $encodedScope = urlencode($scope);

    $response = Http::withHeaders([
        "Content-Type" => "application/x-www-form-urlencoded",
        "Authorization" => "Basic $b64"
    ])->post($link, [
        "grant_type" => "client_credentials",
        "scope" => $encodedScope
    ]);

    return view("test", ["data"=> $response->body()]);
    // return $response->json("access_token");
    // echo("musha");
});