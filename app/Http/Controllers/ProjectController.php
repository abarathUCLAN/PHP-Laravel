<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Project;
use App\UserOwnsProjectRel;
use Response;
use Authorizer;
use Validator;
use DB;
use Input;

class ProjectController extends Controller
{
  protected function getProjects() {
     $projects = DB::table('projects')
        ->select('projects.id', 'name', 'description', 'acronym')
        ->join('Users_Projects_Relationship', function($join)
        {
            $user_id=Authorizer::getResourceOwnerId();
            $join->on('projects.id', '=', 'Users_Projects_Relationship.Project_FK')
                 ->where('Users_Projects_Relationship.User_FK', '=', $user_id);
        })
        ->get();
     //$projects = Project::where('owner', '=', $user_id)->get();
     if(count($projects) == 0)
        return Response::json('', 400);
     else
        return Response::json($projects);
  }

  protected function createProject(Request $request) {
      $array = Input::all();
      $validator = Validator::make($array, [
          'name' => 'required|min:2|max:150|unique:projects',
          'description' => 'required|min:10|max:300',
          'acronym' => 'min:2|max:20'
      ]);

      if($validator->fails())
        return Response::json('', 400);
      else {
        $user_id=Authorizer::getResourceOwnerId();

        $project = new Project();
        $UserOwnsProjectRel = new UserOwnsProjectRel();

        $project->name= $request->input('name');
        $project->description= $request->input('description');
        $project->acronym= $request->input('acronym');

        $project->save();

        $UserOwnsProjectRel->User_FK = $user_id;
        $UserOwnsProjectRel->Project_FK = $project->id;
        $UserOwnsProjectRel->type = '2';
        $UserOwnsProjectRel->save();

        return Response::json($project->id);
      }
  }


}

?>
