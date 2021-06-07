<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Passport\Client;

class AuthController extends Controller
{
    private $client;
    public function __construct() {
        $this->client = Client::find(2);
    }

    public function register(Request $request) {
        $request->validate([
    		'name' => 'required',
    		'email' => 'required',
    		'password' => 'required'
    	]);

    	$user = User::where('email', $request->email)->first();

    	if($user) {
    	    return response()->json([],401);
    	}
    	try {
		    $user = new User();
	    	$user->name= $request->name;
	    	$user->email = $request->email;
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

    	$params = [
        'grant_type' => 'password',
        'password' => $request->password,
        'client_id' => $this->client->id,
        'client_secret' => $this->client->secret,
        'scope' => '*'
      	];
      	$request->request->add($params);
      	$proxy = Request::create('oauth/token','POST');
      	return Route::dispatch($proxy);
    }

    public function login(Request $request) {
        // dd($request->input());
    	 $request->validate([
            'email' => 'required',
            'password' => 'required'
          ]);
          $params = [
            'grant_type' => 'password',
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'email' => $request->email,
            'password' => $request->password,
            'scope' => '*'
          ];
    
          // dd($params);
          $request->request->add($params);
          $proxy = Request::create('oauth/token','POST');
          return Route::dispatch($proxy);
    }

}
