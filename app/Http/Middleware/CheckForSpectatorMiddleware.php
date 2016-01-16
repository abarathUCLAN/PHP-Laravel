<?php

namespace App\Http\Middleware;

use Closure;
use Authorizer;
use App\User;
use App\UserOwnsProjectRel;
use Response;

class CheckForSpectatorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user_id=Authorizer::getResourceOwnerId();
        $projectUrlId = $request->route()->parameters()['id'];

        $relationship = UserOwnsProjectRel::where('User_FK', '=', $user_id)
                                          ->where('Project_FK', '=', $projectUrlId)
                                          ->where('type', '>', 0)->first();

        if ($relationship == null) {
            return Response::json('', 401);
        } else {
            return $next($request);
        }
    }
}
