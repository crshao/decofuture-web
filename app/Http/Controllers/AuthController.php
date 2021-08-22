<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Passport\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
  private $client;
  public function __construct()
  {
    $this->client = Client::find(2);
  }

  public function register(Request $request)
  {

    // dd($request['name']);
    $request->validate([
      'name' => 'required',
      'email' => 'required',
      'password' => 'required',
      'role' => 'required'
    ]);
    $user = User::where('email', $request->email)->first();

    if ($user) {
      return response()->json([], 401);
    }
    try {
      $user = new User();
      $user->name = $request->name;
      $user->email = $request->email;
      $user->role = $request->role;
      $user->password = bcrypt($request->password);
      $user->save();
    } catch (\Exception $e) {
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
    $proxy = Request::create('oauth/token', 'POST');
    // dd($user);
    return Route::dispatch($proxy);
  }

  public function login(Request $request)
  {
    $data_login = "";
    $username = "";
    if (!empty($request->email)) {
      $data_login = 'email';
      $username = $request->email;
    } else {
      $data_login = 'phone_number';
      $username = $request->phone_number;
    }
    // print_r(Client::find(2));
    // dd($request->input());
    // return "test-login";
    // die;
    $request->validate([
      $data_login => 'required',
      'password' => 'required'
    ]);
    $params = [
      'grant_type' => 'password',
      'client_id' => $this->client->id,
      'client_secret' => $this->client->secret,
      'username' => $username,
      'password' => $request->password,
      'scope' => '*'
    ];

    $request->request->add($params);
    $proxy = Request::create('oauth/token', 'POST');

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
    $proxy = Request::create('oauth/token', 'POST');
    return Route::dispatch($proxy);
  }
  public function validate_user(Request $req)
  {
    $data_login = "";
    if (!empty($req->email)) {
      $data_login = 'email';
    } else {
      $data_login = 'phone_number';
    }
    $validator = Validator::make(
      $req->all(),
      [
        $data_login => ['required'],
      ]
    );
    if ($validator->fails()) {
      return response()->json(
        [
          'Status_Request' => false,
          'Message' => $validator->errors()
        ],
        Response::HTTP_UNPROCESSABLE_ENTITY
      );
    }

    $user = User::where($data_login, $req->$data_login)->first();
    try {
      if ($user != null) {
        $response = [
          'Status' => True,
          'Message' => 'User Data',
          'Data' => $user
        ];
        $http_response = Response::HTTP_OK;
      } else {
        $response = [
          'Message' => 'User Data',
          'Data' => 'Email / Phone Not Found!'
        ];
        $http_response = Response::HTTP_NOT_FOUND;
      }

      return response()->json($response, $http_response);
    } catch (ModelNotFoundException $th) {
      return response()->json(['Message' => $th], Response::HTTP_NOT_FOUND);
    }
  }
  public function logout(Request $request)
  {
    $accessToken = Auth::user()->token();
    $refreshToken = DB::table('oauth_refresh_tokens')
      ->where('access_token_id', $accessToken->id)
      ->update(['revoked' => true]);
    $accessToken->revoke();
    return response()->json([], 204);
  }

  public function test()
  {
    return "HALO";
  }
}
