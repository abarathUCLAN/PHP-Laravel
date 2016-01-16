<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, X-Auth-Token, Origin, Authorization');
//Not the best solution for CORS exceptions, but middlewares did not worked.

Route::pattern('id', '[0-9]+');
Route::pattern('riskId', '[0-9]+');
Route::group(['prefix' => 'api'], function () {

    Route::post('users', function () { //login ---- /api/users post
        return Response::json(Authorizer::issueAccessToken());
    });

    Route::post('users/register', ['uses' => 'Auth\AuthController@register']); //register ---- /api/users/register post

    Route::group(['before' => 'oauth'], function () {

      Route::group(['prefix' => 'projects'], function () {
        Route::post('/',  [ 'uses' => 'ProjectController@createProject']);
        Route::post('/addMemberToProject/{id}',  [ 'uses' => 'ProjectController@addMemberToProject']);
        Route::post('/removeProjectMember/{id}',  [ 'uses' => 'ProjectController@removeProjectMember']);
        Route::get('/',  [ 'uses' => 'ProjectController@getProjects']);
        Route::get('/getProjectMembers/{id}',  [ 'uses' => 'ProjectController@getProjectMembers']);
        Route::get('/getProjectName/{id}',  [ 'uses' => 'ProjectController@getProjectName']);
      });

      Route::group(['prefix' => 'invitations'], function () {
          Route::group(['before' => 'projectRights'], function () {
              Route::post('{id}',  [ 'uses' => 'InvitationController@createInvitations']);
          });
          Route::get('{id}',  [ 'uses' => 'InvitationController@getProjectInvitations']);
          Route::post('/deleteInvitation/{id}',  [ 'uses' => 'InvitationController@deleteProjectInvitation']);
          Route::post('/addInvitationToProject/{id}',  [ 'uses' => 'InvitationController@addInvitationToProject']);
      });

      Route::group(['prefix' => 'preliminaryStudy'], function () {
            Route::get('projectDescription/{id}',  [ 'uses' => 'PreliminaryStudyController@getProjectDescription']);
            Route::post('projectDescription/{id}',  [ 'uses' => 'PreliminaryStudyController@insertProjectDescription']);
            Route::post('projectDescription/delete/{id}',  [ 'uses' => 'PreliminaryStudyController@deleteProjectDescription']);

            Route::get('risk/{id}',  [ 'uses' => 'PreliminaryStudyController@getRisks']);
            Route::post('risk/{id}',  [ 'uses' => 'PreliminaryStudyController@insertRisk']);
            Route::post('risk/delete/{id}/{riskId}',  [ 'uses' => 'PreliminaryStudyController@deleteRisk']);

            Route::get('milestone/{id}',  [ 'uses' => 'PreliminaryStudyController@getMilestone']);
            Route::post('milestone/{id}',  [ 'uses' => 'PreliminaryStudyController@insertMilestone']);
            Route::post('milestone/delete/{id}',  [ 'uses' => 'PreliminaryStudyController@deleteMilestone']);

            Route::get('effortEstimation/{id}',  [ 'uses' => 'PreliminaryStudyController@getEffortEstimation']);
            Route::post('effortEstimation/{id}',  [ 'uses' => 'PreliminaryStudyController@insertEffortEstimation']);
            Route::post('effortEstimation/delete/{id}',  [ 'uses' => 'PreliminaryStudyController@deleteEffortEstimation']);
        });

      Route::group(['prefix' => 'requirementSpecification'], function () {
            Route::get('projectIntroduction/{id}',  [ 'uses' => 'RequirementSpecificationController@getProjectIntroduction']);
            Route::post('projectIntroduction/{id}',  [ 'uses' => 'RequirementSpecificationController@insertProjectIntroduction']);
            Route::post('projectIntroduction/delete/{id}',  [ 'uses' => 'RequirementSpecificationController@deleteProjectIntroduction']);

            Route::get('needToHave/{id}',  [ 'uses' => 'RequirementSpecificationController@getNeedToHave']);
            Route::post('needToHave/{id}',  [ 'uses' => 'RequirementSpecificationController@insertNeedToHave']);
            Route::post('needToHave/delete/{id}/{needId}',  [ 'uses' => 'RequirementSpecificationController@deleteNeedToHave']);

            Route::get('niceToHave/{id}',  [ 'uses' => 'RequirementSpecificationController@getNiceToHave']);
            Route::post('niceToHave/{id}',  [ 'uses' => 'RequirementSpecificationController@insertNiceToHave']);
            Route::post('niceToHave/delete/{id}/{niceId}',  [ 'uses' => 'RequirementSpecificationController@deleteNiceToHave']);

            Route::get('projectResult/{id}',  [ 'uses' => 'RequirementSpecificationController@getProjectResult']);
            Route::post('projectResult/{id}',  [ 'uses' => 'RequirementSpecificationController@insertProjectResult']);
            Route::post('projectResult/delete/{id}',  [ 'uses' => 'RequirementSpecificationController@deleteProjectResult']);

            Route::get('projectUse/{id}',  [ 'uses' => 'RequirementSpecificationController@getProjectUse']);
            Route::post('projectUse/{id}',  [ 'uses' => 'RequirementSpecificationController@insertProjectUse']);
            Route::post('projectUse/delete/{id}',  [ 'uses' => 'RequirementSpecificationController@deleteProjectUse']);

            Route::get('actualState/{id}',  [ 'uses' => 'RequirementSpecificationController@getactualState']);
            Route::post('actualState/{id}',  [ 'uses' => 'RequirementSpecificationController@insertactualState']);
            Route::post('actualState/delete/{id}',  [ 'uses' => 'RequirementSpecificationController@deleteactualState']);

            Route::get('targetState/{id}',  [ 'uses' => 'RequirementSpecificationController@getTargetState']);
            Route::post('targetState/{id}',  [ 'uses' => 'RequirementSpecificationController@insertTargetState']);
            Route::post('targetState/delete/{id}',  [ 'uses' => 'RequirementSpecificationController@deleteTargetState']);

            Route::get('productData/{id}',  [ 'uses' => 'RequirementSpecificationController@getProductData']);
            Route::post('productData/{id}',  [ 'uses' => 'RequirementSpecificationController@insertProductData']);
            Route::post('productData/delete/{id}',  [ 'uses' => 'RequirementSpecificationController@deleteProductData']);

            Route::get('nonFunctionalRequirement/{id}',  [ 'uses' => 'RequirementSpecificationController@getNonFunctionalRequirement']);
            Route::post('nonFunctionalRequirement/{id}',  [ 'uses' => 'RequirementSpecificationController@insertNonFunctionalRequirement']);
            Route::post('nonFunctionalRequirement/delete/{id}/{requirementId}',  [ 'uses' => 'RequirementSpecificationController@deleteNonFunctionalRequirement']);

            Route::get('projectQuality/{id}',  [ 'uses' => 'RequirementSpecificationController@getProjectQuality']);
            Route::post('projectQuality/{id}',  [ 'uses' => 'RequirementSpecificationController@insertProjectQuality']);
            Route::post('projectQuality/delete/{id}',  [ 'uses' => 'RequirementSpecificationController@deleteProjectQuality']);
      });

      Route::group(['prefix' => 'functionalSpecification'], function () {
        Route::get('functionalRequirement/{id}',  [ 'uses' => 'FunctionalSpecificationController@getFunctionalRequirement']);
        Route::post('functionalRequirement/{id}',  [ 'uses' => 'FunctionalSpecificationController@insertFunctionalRequirement']);
        Route::post('functionalRequirement/delete/{id}/{requirementId}',  [ 'uses' => 'FunctionalSpecificationController@deleteFunctionalRequirement']);

        Route::get('projectImplementation/{id}',  [ 'uses' => 'FunctionalSpecificationController@getProjectImplementation']);
        Route::post('projectImplementation/{id}',  [ 'uses' => 'FunctionalSpecificationController@insertProjectImplementation']);
        Route::post('projectImplementation/delete/{id}',  [ 'uses' => 'FunctionalSpecificationController@deleteProjectImplementation']);

      });

      Route::group(['prefix' => 'finalization'], function () {
        Route::get('protocol/{id}',  [ 'uses' => 'FinalizationController@getProtocol']);
        Route::post('protocol/{id}',  [ 'uses' => 'FinalizationController@insertProtocol']);
        Route::post('protocol/delete/{id}/{protocolId}',  [ 'uses' => 'FinalizationController@deleteProtocol']);

        Route::get('projectManual/{id}',  [ 'uses' => 'FinalizationController@getProjectManual']);
        Route::post('projectManual/{id}',  [ 'uses' => 'FinalizationController@insertProjectManual']);
        Route::post('projectManual/delete/{id}',  [ 'uses' => 'FinalizationController@deleteProjectManual']);

      });

      Route::group(['prefix' => 'miscellaneous'], function () {
        Route::get('presentation/{id}',  [ 'uses' => 'MiscellaneousController@getPresentation']);
        Route::get('presentation/download/{presentationId}',  [ 'uses' => 'MiscellaneousController@downloadPresentation']);
        Route::post('presentation/{id}',  [ 'uses' => 'MiscellaneousController@insertPresentation']);
        Route::post('presentation/delete/{id}/{presentationId}',  [ 'uses' => 'MiscellaneousController@deletePresentation']);

        Route::get('changeRequest/{id}',  [ 'uses' => 'MiscellaneousController@getChangeRequest']);
        Route::post('changeRequest/{id}',  [ 'uses' => 'MiscellaneousController@insertChangeRequest']);
        Route::post('changeRequest/delete/{id}/{changeId}',  [ 'uses' => 'MiscellaneousController@deleteChangeRequest']);

        Route::get('styleGuide/{id}',  [ 'uses' => 'MiscellaneousController@getStyleGuide']);
        Route::post('styleGuide/{id}',  [ 'uses' => 'MiscellaneousController@insertStyleGuide']);
        Route::post('styleGuide/delete/{id}/{changeId}',  [ 'uses' => 'MiscellaneousController@deleteStyleGuide']);

        Route::get('report/{id}',  [ 'uses' => 'MiscellaneousController@getReport']);
        Route::post('report/{id}',  [ 'uses' => 'MiscellaneousController@insertReport']);
        Route::post('report/delete/{id}/{changeId}',  [ 'uses' => 'MiscellaneousController@deleteReport']);
      });

      Route::group(['prefix' => 'users'], function () {
        Route::post('logout',  [ 'uses' => 'Auth\AuthController@logout']); //logout ---- /api/users/logout post
        Route::get('/',  [ 'uses' => 'UserController@getUserData']);  //get the User's data ---- /api/users get
        Route::post('changeData',  [ 'uses' => 'UserController@changeUserData']); //change the User's data ---- /api/users/changeData post
        Route::post('/getUserByEmail',  [ 'uses' => 'UserController@getUserByEmail']);
      });
   });
});
