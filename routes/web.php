<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
*/

$app->group(['prefix' => env('URL_PREFIX')], function ($app) {
    $app->get('/', function () use ($app) {
        $response = [
            'name' => 'EVENT-API',
            'version' => [
                'number' => env('VERSION_NUMBER'),
                'build_timestamp' => env('BUILD_TIMESTAMP'),
            ]
        ];
        return response()->json($response);
    });
    // Ping route
    $app->get('ping/', function () use ($app) {
        $response = [
            'name' => 'EVENT-API',
            'status' => 'Up',
            'version' => [
                'number' => env('VERSION_NUMBER'),
                'build_timestamp' => env('BUILD_TIMESTAMP'),
            ],
        ];
        return response()->json($response);
    });
});


/*
|--------------------------------------------------------------------------
| Application endpoints
|--------------------------------------------------------------------------
| All endpoints specific for an specific application will be declared under this section
*/
$app->group(['namespace' => 'Application', 'prefix' => env('URL_PREFIX') . 'application' ], function ($app) {
    /**
     * EVENT LOGS
     */
    // log a contact related event
    $app->post('/log/contact', 'EventLogController@storeContactRelated');
    // log a user related event
    $app->post('/log/user', 'EventLogController@storeUserRelated');
    // get all logged events
    $app->get('/log', 'EventLogController@index');
    // get a logged event by id
    $app->get('/log/{id}', 'EventLogController@show');

    /**
     * EVENT TYPES
     */
    // get all event types
    $app->get('/type', 'EventTypeController@index');
    // get event types by category
    $app->get('/type/category', 'EventTypeController@byCategory');

    /**
     * NOTIFICATIONS
     */
    $app->get('/notification/{id:[0-9]+}', 'NotificationController@show');
    $app->get('/notification/subscriber/{id:[0-9]+}', 'NotificationController@bySubscriber');
    $app->put('/notification/{id:[0-9]+}', 'NotificationController@read');

    /**
     * SUBSCRIBERS
     */
    // get a subscriber by passing the member id
    $app->get('/subscriber/member/{id:[0-9]+}', 'SubscriberController@showByMember');
    // create a subscriber by passing the member id
    $app->post('/subscriber', 'SubscriberController@store');
    // update a subscriber by passing the member id
    $app->put('/subscriber/member/{id:[0-9]+}', 'SubscriberController@updateByMember'); // <-------- 3
    // hard delete a subscriber by passing the member id
    $app->delete('/subscriber/member/{id:[0-9]+}', 'SubscriberController@destroyByMember');
    // add an event subscription by passing the subscriber id and event type id
    $app->post('/subscriber/{id:[0-9]+}/subscription/event/{event_type_id:[0-9]+}', 'SubscriberController@storeSubscription');
    // delete an event subscription by passing the subscriber id and event type id
    $app->delete('/subscriber/{id:[0-9]}/subscription/event/{event_type_id:[0-9]+}', 'SubscriberController@destroySubscription');
    // set the subscriber notification preference by passing the subscriber id and preference array
    $app->put('/subscriber/{id:[0-9]}/preference', 'SubscriberController@setPreference');
});
