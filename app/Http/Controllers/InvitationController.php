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
use Mail;

class InvitationController extends Controller
{

    public function __construct()
    {
        $this->middleware('projectRights');
    }

    protected function createInvitations($id, Request $request)
    {
        $user_id=Authorizer::getResourceOwnerId();
        $array = Input::all();
        $failedInvitations = array();

        $requiredValidation = array(
        'firstname' => 'required|min:2|max:25',
        'lastname' => 'required|min:2|max:50',
        'email' => 'required|email|unique:users|unique:invitations',
        'type' => 'required|min:1|max:1'
      );

        for ($i = 0; $i < count($array); $i++) {
            $validator = Validator::make($array[$i], $requiredValidation);

            if ($validator->fails()) {
                array_push($failedInvitations, $array[$i]);
            } else {
                $invitation = new Invitation();
                $urlcode = str_random(40);
                $invitation->urlcode = $urlcode;
                $invitation->firstname = $array[$i]['firstname'];
                $invitation->lastname = $array[$i]['lastname'];
                $invitation->email = $array[$i]['email'];
                $invitation->type = $array[$i]['type'];
                $invitation->owner = $id;

                $invitation->save();

                $data = array('firstname' => $array[$i]['firstname'],
                              'lastname' => $array[$i]['lastname'],
                              'urlcode' => $urlcode);
                //$mail = $array[$i]['email']; uncomment for production
                $mail = "barath1058@gmail.com";

                Mail::send('emails.test', $data, function ($message) use ($mail) {
                          $message->to($mail)
                            ->subject('You got invited to Pdmsys! Check it out!');
                  });
            }
        }
        if (empty($failedInvitations)) {
            return Response::json('', 200);
        } else {
            return Response::json($failedInvitations, 400);
        }
    }


    protected function getProjectInvitations($id)
    {
        if ($id == null) {
            return Response::json('', 400);
        }

        $invitations = Invitation::where('owner', '=', $id)->get();

        if (empty($invitations)) {
            return Response::json('', 400);
        }
        return Response::json($invitations);
    }

    protected function deleteProjectInvitation(Request $request, $id)
    {
        $array = Input::all();
        $validator = Validator::make($array, [
        'email' => 'required|email'
        ]);
        if ($validator->fails()) {
            return Response::json('', 400);
        } else {
            $invitation = Invitation::where('email', '=', $request->input('email'))->first();
            if (empty($invitation)) {
                return Response::json('', 400);
            }
            $invitation->delete();
        }
    }

    protected function addInvitationToProject(Request $request, $id)
    {
        $array = Input::all();
        $validator = Validator::make($array, [
        'firstname' => 'required|min:2|max:25',
        'lastname' => 'required|min:2|max:50',
        'email' => 'required|email|unique:users|unique:invitations',
        'type' => 'required|min:1|max:1'
        ]);
        if ($validator->fails() || $request->input('type') < 0 || $request->input('type') > 2) {
            return Response::json('validation failed.', 400);
        } else {
            $invitation = new Invitation();

            $urlcode = str_random(40);

            $invitation->urlcode =  $urlcode;
            $invitation->firstname =  $request->input('firstname');
            $invitation->lastname =  $request->input('lastname');
            $invitation->email =  $request->input('email');
            $invitation->type =  $request->input('type');
            $invitation->owner =  $id;

            $invitation->save();

            $data = array('firstname' => $request->input('firstname'),
                          'lastname' => $request->input('lastname'),
                          'urlcode' => $urlcode);
            //$mail = $request->input('email'); uncomment for production
            $mail = "barath1058@gmail.com";

            Mail::send('emails.test', $data, function ($message) use ($mail) {
                      $message->to($mail)
                        ->subject('You got invited to Pdmsys! Check it out!');
              });

            return Response::json($invitation);
        }
    }
}
