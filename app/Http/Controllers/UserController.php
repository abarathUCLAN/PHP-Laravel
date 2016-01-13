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
use DB;

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
}
