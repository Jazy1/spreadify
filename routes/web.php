<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/success', function (Request $request) {
    return $request->code;
});

Route::get("auth/ebay/get-application-access-token", function(){
    
    $link = "https://api.sandbox.ebay.com/identity/v1/oauth2/token";
    $clientId = env("EBAY_CLIENT_ID");
    $clientSecert = env("EBAY_CLIENT_SECERT");
    $scope = "https://api.ebay.com/oauth/api_scope";

    $b64 = base64_encode($clientId.":".$clientSecert);
    $encodedScope = urlencode($scope);

    $response = Http::dd()->withHeaders([
        "Authorization" => "Basic SmFoYW56ZWItc3ByZWFkaWYtU0JYLTJjNTk4ZjEzMC02YTQ4OTE4YzpTQlgtYzU5OGYxMzAxMmNkLTJkZTAtNDVlZi04MTNhLWYwNmQ="
    ])->asForm()->post("https://api.sandbox.ebay.com/identity/v1/oauth2/token", [
        "grant_type" => "client_credentials",
        "scope" => $encodedScope
    ]);

    // return $response->status();
    return $response->body();
    // print_r($response);
    // echo("musha");

    // $curl = curl_init();

    // curl_setopt_array($curl, array(
    //   CURLOPT_URL => 'https://api.sandbox.ebay.com/identity/v1/oauth2/token',
    //   CURLOPT_RETURNTRANSFER => true,
    //   CURLOPT_ENCODING => '',
    //   CURLOPT_MAXREDIRS => 10,
    //   CURLOPT_TIMEOUT => 0,
    //   CURLOPT_FOLLOWLOCATION => true,
    //   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //   CURLOPT_CUSTOMREQUEST => 'POST',
    //   CURLOPT_POSTFIELDS => 'grant_type=client_credentials&scope=https%3A%2F%2Fapi.ebay.com%2Foauth%2Fapi_scope',
    //   CURLOPT_HTTPHEADER => array(
    //     'Authorization: Basic SmFoYW56ZWItc3ByZWFkaWYtU0JYLTJjNTk4ZjEzMC02YTQ4OTE4YzpTQlgtYzU5OGYxMzAxMmNkLTJkZTAtNDVlZi04MTNhLWYwNmQ=',
    //     'Content-Type: application/x-www-form-urlencoded',
        
    //   ),
    // ));
    
    // $response = curl_exec($curl);
    
    // curl_close($curl);
    // echo $response;

});
