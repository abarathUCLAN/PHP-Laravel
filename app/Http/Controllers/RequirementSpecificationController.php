<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProjectIntroduction;
use App\NeedToHave;
use App\NiceToHave;
use App\NonFunctionalRequirement;
use App\Result;
use App\ProjectUse;
use App\ProjectQuality;
use App\ActualState;
use App\TargetState;
use App\ProductData;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Response;
use Authorizer;
use Validator;
use Input;
use Log;

class RequirementSpecificationController extends Controller
{

    protected function getProjectIntroduction($id)
    {
        if ($id == null) {
            return Response::json('', 400);
        }

        $introduction = ProjectIntroduction::where('Project_FK', '=', $id)->first();

        if (empty($introduction)) {
            return Response::json('', 400);
        }

        return Response::json($introduction);
    }

    protected function deleteProjectIntroduction($id)
    {
        if ($id == null) {
            return Response::json('invalid id', 400);
        }

        $introduction = ProjectIntroduction::where('Project_FK', '=', $id)->first();

        if (empty($introduction)) {
            return Response::json('empty project introduction', 400);
        }

        $introduction->delete();
    }

    protected function insertProjectIntroduction(Request $request, $id)
    {
        $array = Input::all();
        $validator = Validator::make($array, [
          'content' => 'required'
        ]);
        if ($validator->fails()) {
            return Response::json('', 400);
        } else {
            $introduction = ProjectIntroduction::where('Project_FK', '=', $id)->first();
            if (!empty($introduction)) {
                $introduction->content = $request->input('content');
                $introduction->save();
            } else {
                $introduction = new ProjectIntroduction();

                $introduction->Project_FK = $id;
                $introduction->content = $request->input('content');

                $introduction->save();
            }
        }
    }

    protected function getNeedToHave($id)
    {
        if ($id == null) {
            return Response::json('', 400);
        }

        $need = NeedToHave::where('Project_FK', '=', $id)->get();

        if (count($need) < 1) {
            return Response::json('', 400);
        }

        return Response::json($need);
    }

    protected function deleteNeedToHave($id, $needId)
    {
        if ($id == null || $needId == null) {
            return Response::json('', 400);
        }

        $need = NeedToHave::where('Project_FK', '=', $id)
                    ->where('id', '=', $needId)->first();

        if (empty($need)) {
            return Response::json('', 400);
        }

        $need->delete();
    }

    protected function insertNeedToHave(Request $request, $id)
    {
        $array = Input::all();
        $validator = Validator::make($array, [
          'name' => 'required',
          'content' => 'required'
        ]);
        if ($validator->fails()) {
            return Response::json('', 400);
        } else {
            $need = new NeedToHave();
            $need->Project_FK = $id;
            $need->name = $request->input('name');
            $need->content = $request->input('content');

            $need->save();
            return Response::json($need);
        }
    }



    protected function getNiceToHave($id)
    {
        if ($id == null) {
            return Response::json('', 400);
        }

        $nice = NiceToHave::where('Project_FK', '=', $id)->get();

        if (count($nice) < 1) {
            return Response::json('', 400);
        }

        return Response::json($nice);
    }

    protected function deleteNiceToHave($id, $niceId)
    {
        if ($id == null || $niceId == null) {
            return Response::json('', 400);
        }

        $nice = NiceToHave::where('Project_FK', '=', $id)
                    ->where('id', '=', $niceId)->first();

        if (empty($nice)) {
            return Response::json('', 400);
        }

        $nice->delete();
    }

    protected function insertNiceToHave(Request $request, $id)
    {
        $array = Input::all();
        $validator = Validator::make($array, [
          'name' => 'required',
          'content' => 'required'
        ]);
        if ($validator->fails()) {
            return Response::json('', 400);
        } else {
            $nice = new NiceToHave();
            $nice->Project_FK = $id;
            $nice->name = $request->input('name');
            $nice->content = $request->input('content');

            $nice->save();
            return Response::json($nice);
        }
    }


    protected function getProjectResult($id)
    {
        if ($id == null) {
            return Response::json('', 400);
        }

        $result = Result::where('Project_FK', '=', $id)->first();

        if (empty($result)) {
            return Response::json('', 400);
        }

        return Response::json($result);
    }

    protected function deleteProjectResult($id)
    {
        if ($id == null) {
            return Response::json('invalid id', 400);
        }

        $result = Result::where('Project_FK', '=', $id)->first();

        if (empty($result)) {
            return Response::json('empty project result', 400);
        }

        $result->delete();
    }

    protected function insertProjectResult(Request $request, $id)
    {
        $array = Input::all();
        $validator = Validator::make($array, [
          'content' => 'required'
        ]);
        if ($validator->fails()) {
            return Response::json('', 400);
        } else {
            $result = Result::where('Project_FK', '=', $id)->first();
            if (!empty($result)) {
                $result->content = $request->input('content');
                $result->save();
            } else {
                $result = new Result();

                $result->Project_FK = $id;
                $result->content = $request->input('content');

                $result->save();
            }
        }
    }


    protected function getProjectUse($id)
    {
        if ($id == null) {
            return Response::json('', 400);
        }

        $use = ProjectUse::where('Project_FK', '=', $id)->first();

        if (empty($use)) {
            return Response::json('', 400);
        }

        return Response::json($use);
    }

    protected function deleteProjectUse($id)
    {
        if ($id == null) {
            return Response::json('invalid id', 400);
        }

        $use = ProjectUse::where('Project_FK', '=', $id)->first();

        if (empty($use)) {
            return Response::json('empty project use', 400);
        }

        $use->delete();
    }

    protected function insertProjectUse(Request $request, $id)
    {
        $array = Input::all();
        $validator = Validator::make($array, [
          'content' => 'required'
        ]);
        if ($validator->fails()) {
            return Response::json('', 400);
        } else {
            $use = ProjectUse::where('Project_FK', '=', $id)->first();
            if (!empty($use)) {
                $use->content = $request->input('content');
                $use->save();
            } else {
                $use = new ProjectUse();

                $use->Project_FK = $id;
                $use->content = $request->input('content');

                $use->save();
            }
        }
    }

    protected function getActualState($id)
    {
        if ($id == null) {
            return Response::json('', 400);
        }

        $state = ActualState::where('Project_FK', '=', $id)->first();

        if (empty($state)) {
            return Response::json('', 400);
        }

        return Response::json($state);
    }

    protected function deleteActualState($id)
    {
        if ($id == null) {
            return Response::json('invalid id', 400);
        }

        $state = ActualState::where('Project_FK', '=', $id)->first();

        if (empty($state)) {
            return Response::json('empty project state', 400);
        }

        $state->delete();
    }

    protected function insertActualState(Request $request, $id)
    {
        $array = Input::all();
        $validator = Validator::make($array, [
          'content' => 'required'
        ]);
        if ($validator->fails()) {
            return Response::json('', 400);
        } else {
            $state = ActualState::where('Project_FK', '=', $id)->first();
            if (!empty($state)) {
                $state->content = $request->input('content');
                $state->save();
            } else {
                $state = new ActualState();

                $state->Project_FK = $id;
                $state->content = $request->input('content');

                $state->save();
            }
        }
    }

    protected function getTargetState($id)
    {
        if ($id == null) {
            return Response::json('', 400);
        }

        $state = TargetState::where('Project_FK', '=', $id)->first();

        if (empty($state)) {
            return Response::json('', 400);
        }

        return Response::json($state);
    }

    protected function deleteTargetState($id)
    {
        if ($id == null) {
            return Response::json('invalid id', 400);
        }

        $state = TargetState::where('Project_FK', '=', $id)->first();

        if (empty($state)) {
            return Response::json('empty project state', 400);
        }

        $state->delete();
    }

    protected function insertTargetState(Request $request, $id)
    {
        $array = Input::all();
        $validator = Validator::make($array, [
          'content' => 'required'
        ]);
        if ($validator->fails()) {
            return Response::json('', 400);
        } else {
            $state = TargetState::where('Project_FK', '=', $id)->first();
            if (!empty($state)) {
                $state->content = $request->input('content');
                $state->save();
            } else {
                $state = new TargetState();

                $state->Project_FK = $id;
                $state->content = $request->input('content');

                $state->save();
            }
        }
    }

    protected function getProductData($id)
    {
        if ($id == null) {
            return Response::json('', 400);
        }

        $data = ProductData::where('Project_FK', '=', $id)->first();

        if (empty($data)) {
            return Response::json('', 400);
        }

        return Response::json($data);
    }

    protected function deleteProductData($id)
    {
        if ($id == null) {
            return Response::json('invalid id', 400);
        }

        $data = ProductData::where('Project_FK', '=', $id)->first();

        if (empty($data)) {
            return Response::json('empty project data', 400);
        }

        $data->delete();
    }

    protected function insertProductData(Request $request, $id)
    {
        $array = Input::all();
        $validator = Validator::make($array, [
          'content' => 'required'
        ]);
        if ($validator->fails()) {
            return Response::json('', 400);
        } else {
            $data = ProductData::where('Project_FK', '=', $id)->first();
            if (!empty($data)) {
                $data->content = $request->input('content');
                $data->save();
            } else {
                $data = new ProductData();

                $data->Project_FK = $id;
                $data->content = $request->input('content');

                $data->save();
            }
        }
    }

    protected function getNonFunctionalRequirement($id)
    {
        if ($id == null) {
            return Response::json('', 400);
        }

        $requirement = NonFunctionalRequirement::where('Project_FK', '=', $id)->get();

        if (count($requirement) < 1) {
            return Response::json('', 400);
        }

        return Response::json($requirement);
    }

    protected function deleteNonFunctionalRequirement($id, $requirementId)
    {
        if ($id == null || $requirementId == null) {
            return Response::json('', 400);
        }

        $requirement = NonFunctionalRequirement::where('Project_FK', '=', $id)
                    ->where('id', '=', $requirementId)->first();

        if (empty($requirement)) {
            return Response::json('', 400);
        }

        $requirement->delete();
    }

    protected function insertNonFunctionalRequirement(Request $request, $id)
    {
        $array = Input::all();
        $validator = Validator::make($array, [
          'name' => 'required',
          'content' => 'required'
        ]);
        if ($validator->fails()) {
            return Response::json('validation failed.', 400);
        } else {
            $requirement = new NonFunctionalRequirement();
            $requirement->Project_FK = $id;
            $requirement->name = $request->input('name');
            $requirement->content = $request->input('content');

            $requirement->save();
            return Response::json($requirement);
        }
    }

    protected function getProjectQuality($id)
    {
        if ($id == null) {
            return Response::json('', 400);
        }

        $quality = ProjectQuality::where('Project_FK', '=', $id)->first();

        if (empty($quality)) {
            return Response::json('', 400);
        }

        return Response::json($quality);
    }

    protected function deleteProjectQuality($id)
    {
        if ($id == null) {
            return Response::json('invalid id', 400);
        }

        $quality = ProjectQuality::where('Project_FK', '=', $id)->first();

        if (empty($quality)) {
            return Response::json('empty project quality', 400);
        }

        $quality->delete();
    }

    protected function insertProjectQuality(Request $request, $id)
    {
        $array = Input::all();
        $validator = Validator::make($array, [
          'content' => 'required'
        ]);
        if ($validator->fails()) {
            return Response::json('', 400);
        } else {
            $quality = ProjectQuality::where('Project_FK', '=', $id)->first();
            if (!empty($quality)) {
                $quality->content = $request->input('content');
                $quality->save();
            } else {
                $quality = new ProjectQuality();

                $quality->Project_FK = $id;
                $quality->content = $request->input('content');

                $quality->save();
            }
        }
    }
}
