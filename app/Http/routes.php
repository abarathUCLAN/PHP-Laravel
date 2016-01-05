<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, X-Auth-Token, Origin, Authorization');
//Not the best solution for CORS exceptions, but middlewares did not worked.

Route::pattern('id', '[0-9]+');
Route::group(['prefix' => 'api'], function() {

    Route::post('users', function() { //login ---- /api/users post
        return Response::json(Authorizer::issueAccessToken());
    });

    Route::post('users/register', ['uses' => 'Auth\AuthController@register']); //register ---- /api/users/register post

    Route::group(['before' => 'oauth'], function (){

      Route::group(['prefix' => 'projects'], function() {
        Route::group(['before' => 'projectRights'], function (){
        Route::post('{id}/invitations',  [ 'uses' => 'InvitationController@createInvitations']);
        });
        Route::post('/',  [ 'uses' => 'ProjectController@createProject']);

        Route::get('/',  [ 'uses' => 'ProjectController@getProjects']);

      });

      Route::group(['prefix' => 'users'], function() {
        Route::post('logout',  [ 'uses' => 'Auth\AuthController@logout']); //logout ---- /api/users/logout post
        Route::get('/',  [ 'uses' => 'UserController@getUserData']);  //get the User's data ---- /api/users get
        Route::post('changeData',  [ 'uses' => 'UserController@changeUserData']); //change the User's data ---- /api/users/changeData post
      });
   });
});






/** // return the protected resource
 //echo “success authentication”;
 $user_id=Authorizer::getResourceOwnerId(); // the token user_id
 $user=\App\User::find($user_id);// get the user data from database
return Response::json($user_id);
}]);**/

?>
