<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AcceptanceProtocol;
use App\ProjectManual;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Response;
use Authorizer;
use Validator;
use Input;
use Log;

class FinalizationController extends Controller
{

    protected function getProjectManual($id)
    {
        if ($id == null) {
            return Response::json('', 400);
        }

        $manual = ProjectManual::where('Project_FK', '=', $id)->first();

        if (empty($manual)) {
            return Response::json('', 400);
        }

        return Response::json($manual);
    }

    protected function deleteProjectManual($id)
    {
        if ($id == null) {
            return Response::json('', 400);
        }

        $manual = ProjectManual::where('Project_FK', '=', $id)->first();

        if (empty($manual)) {
            return Response::json('', 400);
        }

        $manual->delete();

        return Response::json();
    }

    protected function insertProjectManual(Request $request, $id)
    {
        $array = Input::all();
        $validator = Validator::make($array, [
          'content' => 'required'
        ]);
        if ($validator->fails()) {
            return Response::json('', 400);
        } else {
            $manual = ProjectManual::where('Project_FK', '=', $id)->first();
            if (!empty($manual)) {
                $manual->content = $request->input('content');
                $manual->save();
            } else {
                $manual = new ProjectManual();

                $manual->Project_FK = $id;
                $manual->content = $request->input('content');

                $manual->save();
            }
        }
    }

    protected function getProtocol($id)
    {
        if ($id == null) {
            return Response::json('', 400);
        }

        $Protocol = AcceptanceProtocol::where('Project_FK', '=', $id)->get();

        if (count($Protocol) < 1) {
            return Response::json('', 400);
        }

        return Response::json($Protocol);
    }

    protected function deleteProtocol($id, $protocolId)
    {
        if ($id == null || $protocolId == null) {
            return Response::json('', 400);
        }

        $Protocol = AcceptanceProtocol::where('Project_FK', '=', $id)
                    ->where('id', '=', $protocolId)->first();

        if (empty($Protocol)) {
            return Response::json('', 400);
        }

        $Protocol->delete();

        return Response::json();
    }

    protected function insertProtocol(Request $request, $id)
    {
        $array = Input::all();
        $validator = Validator::make($array, [
          'criteriaName' => 'required',
          'criteria' => 'required',
          'note' => 'required',
          'requirement' => 'required'
        ]);
        if ($validator->fails()) {
            return Response::json('invalid data', 400);
        } else {
            $Protocol = new AcceptanceProtocol();
            $Protocol->Project_FK = $id;
            $Protocol->criteriaName = $request->input('criteriaName');
            $Protocol->criteria = $request->input('criteria');
            if ($request->input('fulfilled') != null) {
                $Protocol->fulfilled = true;
            } else {
                $Protocol->fulfilled = false;
            }
            $Protocol->note = $request->input('note');
            $Protocol->requirement = $request->input('requirement');

            $Protocol->save();
            return Response::json($Protocol);
        }
    }
}
