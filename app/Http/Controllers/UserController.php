<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Response;
use Log;
use Input;
use Validator;
use Authorizer;

class UserController extends Controller
{

    protected function getUserByEmail(Request $request)
    {
        $array = Input::all();
        $validator = Validator::make($array, [
            'email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            return Response::json('validation failed.', 400);
        } else {
            $user = User::where('email', '=', $request->input('email'))->get();
            if (empty($user)) {
                return Response::json('', 400);
            }
            return Response::json($user, 200);
        }
    }

    protected function getUserData()
    {
        $user_id=Authorizer::getResourceOwnerId();
        if ($user_id == null) {
            return Response::json('invalid user id', 400);
        }

        $user = User::where('id', '=', $user_id)->first();

        if (empty($user)) {
            return Response::json('invalid user found', 400);
        }

        return Response::json($user);
    }

    protected function changeUserData(Request $request)
    {
        $array = Input::all();
        $user_id=Authorizer::getResourceOwnerId();
        if ($user_id == null) {
            return Response::json('invalid user id', 400);
        }

        $user = User::where('id', '=', $user_id)->first();

        if (empty($user)) {
            return Response::json('invalid user found', 400);
        }

        $user->firstname= $request->input('firstname');
        $user->lastname= $request->input('lastname');
        $user->password = \Illuminate\Support\Facades\Hash::make($request->input('password'));
        $user->save();
    }
}
