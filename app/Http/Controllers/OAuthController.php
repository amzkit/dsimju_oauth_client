<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OAuthController extends Controller
{
    //

    public function redirect(Request $request){
        
        $queries = http_build_query([
            'client_id'     =>  config("oauth.client_id"),
            'redirect_uri'  =>  config("oauth.callback_redirect_uri"),
            'response_type' =>  'code',
        ]);
        return redirect(config("oauth.authorize_url")."?".$queries);
    }

    public function callback(Request $request){
        $response = Http::post(config("oauth.request_token_url"), [
            'grant_type'    =>  'authorization_code',
            'client_id'     =>  config("oauth.client_id"),
            'client_secret' =>  config("oauth.client_secret"),
            'redirect_uri'  =>  config("oauth.callback_redirect_uri"),
            'code'          =>  $request->code,
        ]);

        $response = $response->json();
        
        // Use Access Token to get User infomation
        $accessToken = $response['access_token'];
        $user = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$accessToken,
        ])->get(config("oauth.request_user_url"));

        $user_tmp = $user->json();
        //dd($user->json());

        $user = [];
        $user['id'] = $user_tmp['id'];
        $user['name'] = $user_tmp['name'];
        $user['email'] = $user_tmp['email'];

        $user = \App\Models\User::updateOrCreate($user);

        \Auth::login($user);

        return redirect('/home');
        
    }
}
