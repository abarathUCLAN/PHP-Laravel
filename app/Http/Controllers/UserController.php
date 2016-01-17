<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Invitation;
use App\UserOwnsProjectRel;
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

    protected function checkIfUrlCodeIsValid(Request $request)
    {
        $array = Input::all();
        $validator = Validator::make($array, [
            'urlcode' => 'min:40|max:40|required',
        ]);

        if ($validator->fails()) {
            return Response::json('wrong urlcode', 400);
        } else {
            $invitation = Invitation::where('urlcode', '=', $request->input('urlcode'))->first();
            if (empty($invitation)) {
                return Response::json('no invitation found', 400);
            }
        }
    }

    protected function registerUserWithUrlCode(Request $request)
    {
        $array = Input::all();
        $validator = Validator::make($array, [
          'urlcode' => 'min:40|max:40|required',
          'password' => 'min:8|max:16|required',
      ]);

        if ($validator->fails()) {
            return Response::json('wrong urlcode or password', 400);
        } else {
            $invitation = Invitation::where('urlcode', '=', $request->input('urlcode'))->first();

            if (empty($invitation)) {
                return Response::json('no invitation found', 400);
            }

            $projectId = $invitation->owner;
            $type = $invitation->type;

            $invitation->delete();

            $user = new User();
            $user->firstname = $invitation->firstname;
            $user->lastname = $invitation->lastname;
            $user->email = $invitation->email;
            $user->password = \Illuminate\Support\Facades\Hash::make($request->input('password'));
            $user->save();

            $users_projects_rel = new UserOwnsProjectRel();

            $users_projects_rel->User_FK = $user->id;
            $users_projects_rel->Project_FK = $projectId;
            $users_projects_rel->type = $type;
            $users_projects_rel->save();
        }
    }
}
