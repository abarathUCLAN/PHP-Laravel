<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use DB;
use Authorizer;
use Response;
use Illuminate\Http\Request;
use Input;

class AuthController extends Controller
{

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    protected function logout()
    {
      $user_id=Authorizer::getResourceOwnerId();
      DB::table('oauth_sessions')->where('owner_id', '=', $user_id)->delete();
    }

    protected function register(Request $request)
    {
      $array = Input::all();
      $validator = Validator::make($array, [
          'firstname' => 'required|max:20',
          'lastname' => 'required|max:30',
          'email' => 'required|email|max:255|unique:users',
          'password' => 'required|min:6'
      ]);

      if ($validator->fails())
          return Response::json($validator->fails(),400);
      else {
          $user = new User();
          $user->firstname= $request->input('firstname');
          $user->lastname= $request->input('lastname');
          $user->email= $request->input('email');
          $user->password = \Illuminate\Support\Facades\Hash::make($request->input('password'));
          $user->save();

          return Response::json($user);
        }
    }
}
?>
