<?php

Route::group(['middleware' => ['cors', 'api']], function () {
    Route::post('/auth/token/issue', 'AuthController@issueToken');
    Route::post('/auth/token/refresh', 'AuthController@refreshToken');
    Route::get('/me', 'MeController@show');
        Route::get('batches/unsign', 'BatchesController@unsign');
        Route::resource('batches', 'BatchesController');
        Route::get('/batches/{id}/samples', 'SamplesController@batchSamples');
        Route::resource('samples', 'SamplesController');
        Route::resource('projects', 'ProjectsController');
        Route::get('/projects/{id}/tasks', 'TasksController@projectTasks');
        Route::patch('tasks/{id}/push', 'TasksController@push');
        Route::resource('tasks', 'TasksController');
        Route::group(['prefix' => 'experiments'], function () {
            Route::get('splits', 'ExperimentsController@splits');
            Route::get('extractions', 'ExperimentsController@extractions');
            Route::get('dilutions', 'ExperimentsController@dilutions');
            Route::get('distributions', 'ExperimentsController@distributions');
            Route::get('analysises', 'ExperimentsController@analysises');
            Route::get('poolings', 'ExperimentsController@poolings');
            Route::get('libraries', 'ExperimentsController@libraries');
            Route::get('sequences', 'ExperimentsController@sequences');
        });
        Route::resource('experiments', 'ExperimentsController');
        Route::resource('qcs', 'QcsController');
        Route::resource('results', 'ResultsController');
        Route::resource('pipelines', 'PipelinesController');
        Route::resource('protocols', 'ProtocolsController');
        Route::get('procedures', 'ProceduresController@index');
    // Route::group(['middleware' => ''], function () {
    //     Route::get('/me', 'MeController@show');
    //     Route::get('batches/unsign', 'BatchesController@unsign');
    //     Route::resource('batches', 'BatchesController');
    //     Route::get('/batches/{id}/samples', 'SamplesController@batchSamples');
    //     Route::resource('samples', 'SamplesController');
    //     Route::resource('projects', 'ProjectsController');
    //     Route::get('/projects/{id}/tasks', 'TasksController@projectTasks');
    //     Route::patch('tasks/{id}/push', 'TasksController@push');
    //     Route::resource('tasks', 'TasksController');
    //     Route::group(['prefix' => 'experiments'], function () {
    //         Route::get('splits', 'ExperimentsController@splits');
    //         Route::get('extractions', 'ExperimentsController@extractions');
    //         Route::get('dilutions', 'ExperimentsController@dilutions');
    //         Route::get('distributions', 'ExperimentsController@distributions');
    //         Route::get('analysises', 'ExperimentsController@analysises');
    //         Route::get('poolings', 'ExperimentsController@poolings');
    //         Route::get('libraries', 'ExperimentsController@libraries');
    //         Route::get('sequences', 'ExperimentsController@sequences');
    //     });
    //     Route::resource('experiments', 'ExperimentsController');
    //     Route::resource('qcs', 'QcsController');
    //     Route::resource('results', 'ResultsController');
    //     Route::resource('pipelines', 'PipelinesController');
    //     Route::resource('protocols', 'ProtocolsController');
    //     Route::get('procedures', 'ProceduresController@index');
    // });
});