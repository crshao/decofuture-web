<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Passport\Client;
use App\Models\User;
use Illuminate\Support\Facades\Route;

class AuthController extends Controller
{
    private $client;
    public function __construct() {
        $this->client = Client::find(2);
    }

    public function register(Request $request) {
        
        // dd($request['name']);
        $request->validate([
    		'name' => 'required',
    		'email' => 'required',
    		'password' => 'required',
        'role' => 'required'
    	]);
    	$user = User::where('email', $request->email)->first();
        
    	if($user) {
    	    return response()->json([],401);
    	}
    	try {
		    $user = new User();
	    	$user->name= $request->name;
	    	$user->email = $request->email;
            $user->role = $request->role;
	    	$user->password = bcrypt($request->password);
	    	$user->save();
		}
        catch (\Exception $e) {
            $user->delete();
            return response()->json([
                'status' => 500,
                'message' => $e
			]);
		}
        // dd($user);
        
    	$params = [
        'grant_type' => 'password',
        'username' => $request->email,
        'password' => $request->password,
        'client_id' => $this->client->id,
        'client_secret' => $this->client->secret,
        'scope' => '*'
      	];
      	$request->request->add($params);
      	$proxy = Request::create('oauth/token','POST');
        // dd($user);
      	return Route::dispatch($proxy);
    }

    public function login(Request $request) {
        // dd($request->input());
        // return "test-login";

    	 $request->validate([
            'email' => 'required',
            'password' => 'required'
          ]);
          $params = [
            'grant_type' => 'password',
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'username' => $request->email,
            'password' => $request->password,
            'scope' => '*'
          ];
    
        //   dd($params);
          $request->request->add($params);
          $proxy = Request::create('oauth/token','POST');
          
          return Route::dispatch($proxy);
    }

    public function refresh(Request $request)
    {
        $request->validate([
            'refresh_token' => 'required'
          ]);
          $params = [
            'grant_type' => 'refresh_token',
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'username' => $request->email,
            'password' => $request->password,
          ];
          $request->request->add($params);
          $proxy = Request::create('oauth/token','POST');
          return Route::dispatch($proxy);
        }
        
        public function logout(Request $request){
            $accessToken = Auth::user()->token();
            $refreshToken = DB::table('oauth_refresh_tokens')
                          ->where('access_token_id',$accessToken->id)
                          ->update(['revoked' => true]);
              $accessToken->revoke();
              return response()->json([],204);
    }

    public function test()
    {
        return "HALO";
    }

}
