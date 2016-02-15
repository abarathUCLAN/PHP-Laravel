<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Presentation;
use App\StyleGuide;
use App\Report;
use App\ChangeRequest;
use Response;
use Authorizer;
use Validator;
use Input;
use Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class MiscellaneousController extends Controller
{

    protected function insertPresentation(Request $request, $id)
    {
        $file = Input::file('file');
        $array['name'] = Input::get('name');
        $array['content'] = Input::get('content');
        $array['file'] = $file->getClientOriginalName();
        $validator = Validator::make($array, [
          'name' => 'required',
          'content' => 'required',
          'file' => 'required|unique:presentations',
        ]);
        if ($validator->fails()) {
            return Response::json('validator failed', 400);
        } else {
            $presentation = new Presentation();

            $presentation->name = $array['name'];
            $presentation->content = $array['content'];
            $presentation->file = $array['file'];
            $presentation->Project_FK = $id;

            $file->move(base_path() . '/public/presentations/', $array['file']);

            $presentation->save();

            return Response::json($presentation, 200);
        }
    }

    protected function getPresentation($id)
    {
        if ($id == null) {
            return Response::json('', 400);
        }

        $presentation = Presentation::where('Project_FK', '=', $id)->get();

        if (count($presentation) < 1) {
            return Response::json('', 400);
        }

        return Response::json($presentation);
    }

    protected function downloadPresentation($presentationId)
    {
        if ($presentationId == null) {
            return Response::json('invalid id', 400);
        }

        $presentation = Presentation::where('id', '=', $presentationId)->first();

        if (empty($presentation)) {
            return Response::json('no presentation found', 400);
        }

        return Response::download(base_path() . "/public/presentations/" . $presentation->file);
    }

    protected function deletePresentation($id, $presentationId)
    {
        if ($id == null || $presentationId == null) {
            return Response::json('invalid ids', 400);
        }

        $Presentation = Presentation::where('Project_FK', '=', $id)
                    ->where('id', '=', $presentationId)->first();

        if (empty($Presentation)) {
            return Response::json('presentation is empty', 400);
        }

        \File::Delete(public_path() . "\\presentations\\" . $Presentation->file);

        $Presentation->delete();
    }


    protected function getChangeRequest($id)
    {
        if ($id == null) {
            return Response::json('', 400);
        }

        $ChangeRequest = ChangeRequest::where('Project_FK', '=', $id)->get();

        if (count($ChangeRequest) < 1) {
            return Response::json('', 400);
        }

        return Response::json($ChangeRequest);
    }

    protected function deleteChangeRequest($id, $changeId)
    {
        if ($id == null || $changeId == null) {
            return Response::json('', 400);
        }

        $ChangeRequest = ChangeRequest::where('Project_FK', '=', $id)
                    ->where('id', '=', $changeId)->first();

        if (empty($ChangeRequest)) {
            return Response::json('', 400);
        }

        $ChangeRequest->delete();

        return Response::json();
    }

    protected function insertChangeRequest(Request $request, $id)
    {
        $array = Input::all();
        $validator = Validator::make($array, [
          'name' => 'required',
          'content' => 'required'
        ]);
        if ($validator->fails()) {
            return Response::json('', 400);
        } else {
            $ChangeRequest = new ChangeRequest();
            $ChangeRequest->Project_FK = $id;
            $ChangeRequest->name = $request->input('name');
            $ChangeRequest->content = $request->input('content');

            $ChangeRequest->save();
            return Response::json($ChangeRequest);
        }
    }

    protected function getStyleGuide($id)
    {
        if ($id == null) {
            return Response::json('', 400);
        }

        $StyleGuide = StyleGuide::where('Project_FK', '=', $id)->get();

        if (count($StyleGuide) < 1) {
            return Response::json('', 400);
        }

        return Response::json($StyleGuide);
    }

    protected function deleteStyleGuide($id, $styleId)
    {
        if ($id == null || $styleId == null) {
            return Response::json('', 400);
        }

        $StyleGuide = StyleGuide::where('Project_FK', '=', $id)
                    ->where('id', '=', $styleId)->first();

        if (empty($StyleGuide)) {
            return Response::json('', 400);
        }

        $StyleGuide->delete();

        return Response::json();
    }

    protected function insertStyleGuide(Request $request, $id)
    {
        $array = Input::all();
        $validator = Validator::make($array, [
          'name' => 'required',
          'content' => 'required'
        ]);
        if ($validator->fails()) {
            return Response::json('', 400);
        } else {
            $StyleGuide = new StyleGuide();
            $StyleGuide->Project_FK = $id;
            $StyleGuide->name = $request->input('name');
            $StyleGuide->content = $request->input('content');

            $StyleGuide->save();
            return Response::json($StyleGuide);
        }
    }

    protected function getReport($id)
    {
        if ($id == null) {
            return Response::json('', 400);
        }

        $Report = Report::where('Project_FK', '=', $id)->get();

        if (count($Report) < 1) {
            return Response::json('', 400);
        }

        return Response::json($Report);
    }

    protected function deleteReport($id, $reportId)
    {
        if ($id == null || $reportId == null) {
            return Response::json('', 400);
        }

        $Report = Report::where('Project_FK', '=', $id)
                    ->where('id', '=', $reportId)->first();

        if (empty($Report)) {
            return Response::json('', 400);
        }

        $Report->delete();

        return Response::json();
    }

    protected function insertReport(Request $request, $id)
    {
        $array = Input::all();
        $validator = Validator::make($array, [
          'month' => 'required',
          'content' => 'required'
        ]);
        if ($validator->fails()) {
            return Response::json('', 400);
        } else {
            $Report = new Report();
            $Report->Project_FK = $id;
            $Report->month = $request->input('month');
            $Report->content = $request->input('content');

            $Report->save();
            return Response::json($Report);
        }
    }
}
