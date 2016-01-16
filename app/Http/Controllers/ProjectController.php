<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Project;
use App\User;
use App\UserOwnsProjectRel;
use Response;
use Authorizer;
use Validator;
use DB;
use Input;

class ProjectController extends Controller
{
    protected function getProjects()
    {
        $projects = DB::table('projects')
        ->select('projects.id', 'name', 'description', 'acronym')
        ->join('Users_Projects_Relationship', function ($join) {
            $user_id=Authorizer::getResourceOwnerId();
            $join->on('projects.id', '=', 'Users_Projects_Relationship.Project_FK')
                 ->where('Users_Projects_Relationship.User_FK', '=', $user_id);
        })
        ->get();
     //$projects = Project::where('owner', '=', $user_id)->get();
     if (count($projects) == 0) {
         return Response::json('', 400);
     } else {
         return Response::json($projects);
     }
    }

    protected function getProjectRights($id)
    {
        $user_id=Authorizer::getResourceOwnerId();
        if ($user_id == null) {
            return Response::json('invalid user id', 401);
        }
        $users_projects_rel = UserOwnsProjectRel::where('User_FK', '=', $user_id)
                                                ->where('Project_FK', '=', $id)->first();
        if (empty($users_projects_rel)) {
            return Response::json('no relationship object found', 401);
        }
        return Response::json($users_projects_rel->type);
    }

    protected function addMemberToProject(Request $request, $id)
    {
        $array = Input::all();
        $validator = Validator::make($array, [
          'email' => 'required|email',
          'type' => 'required|min:1|max:1'
        ]);
        if ($validator->fails() || $request->input('type') < 0 || $request->input('type') > 2) {
            return Response::json('validation failed.', 400);
        } else {
            $user = User::where('email', '=', $request->input('email'))->get();
            $existingRelationToProject = UserOwnsProjectRel::where('User_FK', '=', $user[0]->id)
                                                            ->where('Project_FK', '=', $id)
                                                            ->count();
            if (empty($user)) {
                return Response::json('no user found.', 400);
            }

            if ($existingRelationToProject > 0) {
                return Response::json('relation already exists', 400);
            }

            $users_projects_rel = new UserOwnsProjectRel();

            $users_projects_rel->User_FK = $user[0]->id;
            $users_projects_rel->Project_FK = $id;
            $users_projects_rel->type = $request->input('type');
            $users_projects_rel->save();
            return Response::json($user);
        }
    }

    protected function getProjectName($id)
    {
        if ($id == null) {
            return Response::json('invalid projectid', 400);
        }

        $project = Project::where('id', '=', $id)->first();

        if (empty($project)) {
            return Response::json('no project with that id available.', 400);
        }

        return Response::json($project);
    }

    protected function getProjectMembers($id)
    {
        return Response::json(DB::table('Users_Projects_Relationship')
        ->select('users.firstname', 'users.lastname', 'users.email', 'type', 'users.id')
        ->join('users', function ($join) use ($id) {
            $join->on('users.id', '=', 'Users_Projects_Relationship.User_FK')
                 ->where('Users_Projects_Relationship.Project_FK', '=', $id);
        })
        ->get());
    }

    protected function removeProjectMember(Request $request, $id)
    {
        $array = Input::all();
        $validator = Validator::make($array, [
        'email' => 'required|email'
        ]);
        if ($validator->fails()) {
            return Response::json('', 400);
        } else {
            $user = User::where('email', '=', $request->input('email'))->get();
            if (empty($user)) {
                return Response::json('', 400);
            }
            $users_projects_rel = UserOwnsProjectRel::where('User_FK', '=', $user[0]->id)
                                                    ->where('Project_FK', '=', $id)
                                                    ->delete();
        }
    }

    protected function createProject(Request $request)
    {
        $array = Input::all();
        $validator = Validator::make($array, [
          'name' => 'required|min:2|max:150|unique:projects',
          'description' => 'required|min:10|max:300'
      ]);

        if ($validator->fails()) {
            return Response::json('validation failed', 400);
        } else {
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
