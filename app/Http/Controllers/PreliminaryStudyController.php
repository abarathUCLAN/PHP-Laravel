<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProjectDescription;
use App\Risk;
use App\Milestone;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Response;
use Authorizer;
use Validator;
use Input;
use Log;

class PreliminaryStudyController extends Controller
{

    protected function getProjectDescription($id)
    {
        if ($id == null) {
            return Response::json('', 400);
        }

        $description = ProjectDescription::where('Project_FK', '=', $id)->first();

        if (empty($description)) {
            return Response::json('', 400);
        }

        return Response::json($description);
    }

    protected function deleteProjectDescription($id)
    {
        if ($id == null) {
            return Response::json('', 400);
        }

        $description = ProjectDescription::where('Project_FK', '=', $id)->first();

        if (empty($description)) {
            return Response::json('', 400);
        }

        $description->delete();

        return Response::json();
    }

    protected function insertProjectDescription(Request $request, $id)
    {
        $array = Input::all();
        $validator = Validator::make($array, [
          'description' => 'required'
        ]);
        if ($validator->fails()) {
            return Response::json('', 400);
        } else {
            $projectDescription = ProjectDescription::where('Project_FK', '=', $id)->first();
            if (!empty($projectDescription)) {
                $projectDescription->description = $request->input('description');
                $projectDescription->save();
            } else {
                $projectDescription = new ProjectDescription();

                $projectDescription->Project_FK = $id;
                $projectDescription->description = $request->input('description');

                $projectDescription->save();
            }
        }
    }

    protected function getRisks($id)
    {
        if ($id == null) {
            return Response::json('', 400);
        }

        $risk = Risk::where('Project_FK', '=', $id)->get();

        if (count($risk) < 1) {
            return Response::json('', 400);
        }

        return Response::json($risk);
    }

    protected function deleteRisk($id, $riskId)
    {
        if ($id == null || $riskId == null) {
            return Response::json('', 400);
        }

        $risk = Risk::where('Project_FK', '=', $id)
                    ->where('id', '=', $riskId)->first();

        if (empty($risk)) {
            return Response::json('', 400);
        }

        $risk->delete();

        return Response::json();
    }

    protected function insertRisk(Request $request, $id)
    {
        $array = Input::all();
        $validator = Validator::make($array, [
          'name' => 'required',
          'content' => 'required'
        ]);
        if ($validator->fails()) {
            return Response::json('', 400);
        } else {
            $risk = new Risk();
            $risk->Project_FK = $id;
            $risk->name = $request->input('name');
            $risk->content = $request->input('content');

            $risk->save();
            return Response::json($risk);
        }
    }




    protected function getMilestone($id)
    {
        if ($id == null) {
            return Response::json('invalid id', 400);
        }

        $milestone = Milestone::where('Project_FK', '=', $id)->first();

        if (empty($milestone)) {
            return Response::json('no milestone available', 400);
        }

        return Response::json($milestone->content);
    }

    protected function deleteMilestone($id)
    {
        if ($id == null) {
            return Response::json('', 400);
        }

        $milestone = Milestone::where('Project_FK', '=', $id)->first();

        if (empty($milestone)) {
            return Response::json('', 400);
        }

        $milestone->delete();

        return Response::json();
    }

    protected function insertMilestone(Request $request, $id)
    {
        $milestone = Milestone::where('Project_FK', '=', $id)->first();
        if (!empty($milestone)) {
            $milestone->content = json_encode($request->input('content'));
            $milestone->save();
        } else {
            $milestone = new Milestone();

            $milestone->Project_FK = $id;
            $milestone->content = json_encode($request->input('content'));

            $milestone->save();
        }
    }


    protected function getEffortEstimation($id)
    {
        if ($id == null) {
            return Response::json('invalid id', 400);
        }

        $milestone = Milestone::where('Project_FK', '=', $id)->first();

        if (empty($milestone)) {
            return Response::json('no milestone available', 400);
        }

        return Response::json($milestone->content);
    }

    protected function deleteEffortEstimation($id)
    {
        if ($id == null) {
            return Response::json('', 400);
        }

        $milestone = Milestone::where('Project_FK', '=', $id)->first();

        if (empty($milestone)) {
            return Response::json('', 400);
        }

        $milestone->delete();

        return Response::json();
    }

    protected function insertEffortEstimation(Request $request, $id)
    {
        $milestone = Milestone::where('Project_FK', '=', $id)->first();
        if (!empty($milestone)) {
            $milestone->content = json_encode($request->input('content'));
            $milestone->save();
        } else {
            $milestone = new Milestone();

            $milestone->Project_FK = $id;
            $milestone->content = json_encode($request->input('content'));

            $milestone->save();
        }
    }
}
