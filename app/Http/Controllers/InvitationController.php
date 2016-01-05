<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invitation;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Response;
use Authorizer;
use Validator;
use Input;
use Log;

class InvitationController extends Controller
{

    public function __construct()
    {
      $this->middleware('projectRights');
    }

    protected function createInvitations($id, Request $request) {
      $user_id=Authorizer::getResourceOwnerId();
      $array = Input::all();
      $failedInvitations = array();

      $requiredValidation = array(
        'firstname' => 'required|min:2|max:25',
        'lastname' => 'required|min:2|max:50',
        'email' => 'required|email|unique:users|unique:invitations',
        'type' => 'required|min:1|max:1'
      );

      for($i = 0; $i < count($array); $i++) {
        $validator = Validator::make($array[$i], $requiredValidation);

        if($validator->fails())
          array_push($failedInvitations, $array[$i]);
        else {
          $invitation = new Invitation();

          $invitation->firstname = $array[$i]['firstname'];
          $invitation->lastname = $array[$i]['lastname'];
          $invitation->email = $array[$i]['email'];
          $invitation->type = $array[$i]['type'];
          $invitation->owner = $id;

          $invitation->save();
          }
        }
        if(empty($failedInvitations))
          return Response::json('', 200);
        else
          return Response::json($failedInvitations, 400);
    }
}

?>
