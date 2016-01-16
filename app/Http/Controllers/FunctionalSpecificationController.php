<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\FunctionalRequirement;
use App\ProjectImplementation;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Response;
use Authorizer;
use Validator;
use Input;
use Log;

class FunctionalSpecificationController extends Controller
{

    protected function getProjectImplementation($id)
    {
        if ($id == null) {
            return Response::json('', 400);
        }

        $Implementation = ProjectImplementation::where('Project_FK', '=', $id)->first();

        if (empty($Implementation)) {
            return Response::json('', 400);
        }

        return Response::json($Implementation);
    }

    protected function deleteProjectImplementation($id)
    {
        if ($id == null) {
            return Response::json('', 400);
        }

        $Implementation = ProjectImplementation::where('Project_FK', '=', $id)->first();

        if (empty($Implementation)) {
            return Response::json('', 400);
        }

        $Implementation->delete();

        return Response::json();
    }

    protected function insertProjectImplementation(Request $request, $id)
    {
        $array = Input::all();
        $validator = Validator::make($array, [
          'content' => 'required'
        ]);
        if ($validator->fails()) {
            return Response::json('', 400);
        } else {
            $projectImplementation = ProjectImplementation::where('Project_FK', '=', $id)->first();
            if (!empty($projectImplementation)) {
                $projectImplementation->content = $request->input('content');
                $projectImplementation->save();
            } else {
                $projectImplementation = new ProjectImplementation();

                $projectImplementation->Project_FK = $id;
                $projectImplementation->content = $request->input('content');

                $projectImplementation->save();
            }
        }
    }

    protected function getFunctionalRequirement($id)
    {
        if ($id == null) {
            return Response::json('', 400);
        }

        $FunctionalRequirement = FunctionalRequirement::where('Project_FK', '=', $id)->get();

        if (count($FunctionalRequirement) < 1) {
            return Response::json('', 400);
        }

        return Response::json($FunctionalRequirement);
    }

    protected function deleteFunctionalRequirement($id, $requirementId)
    {
        if ($id == null || $requirementId == null) {
            return Response::json('', 400);
        }

        $FunctionalRequirement = FunctionalRequirement::where('Project_FK', '=', $id)
                    ->where('id', '=', $requirementId)->first();

        if (empty($FunctionalRequirement)) {
            return Response::json('', 400);
        }

        $FunctionalRequirement->delete();

        return Response::json();
    }

    protected function insertFunctionalRequirement(Request $request, $id)
    {
        $array = Input::all();
        $validator = Validator::make($array, [
          'name' => 'required',
          'content' => 'required'
        ]);
        if ($validator->fails()) {
            return Response::json('', 400);
        } else {
            $FunctionalRequirement = new FunctionalRequirement();
            $FunctionalRequirement->Project_FK = $id;
            $FunctionalRequirement->name = $request->input('name');
            $FunctionalRequirement->content = $request->input('content');

            $FunctionalRequirement->save();
            return Response::json($FunctionalRequirement);
        }
    }
}
