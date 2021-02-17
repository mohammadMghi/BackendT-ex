<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Client as OClient; 
use Illuminate\Support\Facades\Http;
class AuthController extends Controller
{
    public function register(Request $request) { 
        $validator = Validator::make($request->all(), [ 
            'nikname' => 'required|string', 
            'phone_number' => 'required|unique:users|string', 
            'password' => 'required', 
        ]);
 
        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $password = $request->password;
        $input = $request->all(); 
        $input['password'] = bcrypt($input['password']); 
      
        $user = User::create([
            "password" => $input['password'],
            "nikname" => $input['nikname'],
            "phone_number" => $input['phone_number']
        ]);


        $oClient = OClient::where('password_client', 1)->first();
        return $this->getTokenAndRefreshToken($oClient, $user->phone_number, $password);
    }


    public function login() { 
     
        if (Auth::attempt(['phone_number' => request('phone_number'), 'password' => request('password')])) { 
            $oClient = OClient::where('password_client', 1)->first();
 
            return $this->getTokenAndRefreshToken($oClient, request('phone_number'), request('password'));
        } 
        else { 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }

    public function refreshToken() { 
        $oClient = OClient::where('password_client', 1)->first();
     
        return $this->newTokenWithRefreshToken($oClient,request('refresh_token'));
    }


    public function getTokenAndRefreshToken(OClient $oClient, $phoneNumber, $password) { 
 
        $response = Http::asForm()->post('http://127.0.0.1:8001/oauth/token', [
            'grant_type' => 'password',
            'client_id' => $oClient->id,
            'client_secret' => $oClient->secret,
            'username' => $phoneNumber,
            'password' => $password,
            'scope' => '',
        ]);
        
       
            
        return $response->json();

    }

 
    public function newTokenWithRefreshToken(OClient $oClient, $refreshToken) { 
 
       
        $response = Http::asForm()->post('http://127.0.0.1:8001/oauth/token', [
         'grant_type' => 'refresh_token',
         'refresh_token' => $refreshToken,
         'client_id' => $oClient->id,
         'client_secret' => $oClient->secret,
         'scope' => '',
        ]);

        return $response->json();

    }

}
