<?php

require_once __DIR__ . '/vendor/autoload.php';

foreach (glob("controllers/*Controller.php") as $filename)
    require_once $filename;

$klein = new \Klein\Klein();

/*
 * DATABASE
 ***************/

$klein->respond(function ($request, $response, $service, $app) {
    $app->register('db', function() {
        return new PDO('mysql:host=database;dbname=labmanager', 'labmanager', 'labmanager');
    });
});

/*
 * ROUTES
 ***************/

$klein->respond('GET', '/', ['IndexController', 'get']);

// Admin

$klein->respond('GET', '/admin/studente', ['StudentController', 'getStudents']);
$klein->respond('POST', '/admin/studente', ['StudentController', 'addStudent']);

$klein->respond('GET', '/admin/classe', ['ClassController', 'getClasses']);
$klein->respond('POST', '/admin/classe', ['ClassController', 'addClass']);
$klein->respond('PUT', '/admin/classe', ['ClassController', 'modifyClass']);
$klein->respond('DELETE', '/admin/classe', ['ClassController', 'deleteClass']);
$klein->respond('POST', '/admin/classe/enable', ['ClassController', 'activateClass']);
$klein->respond('DELETE', '/admin/classe/enable', ['ClassController', 'disableClass']);

$klein->respond('GET', '/admin/utensile', ['ToolsController', 'getTools']);
$klein->respond('GET', '/admin/categoria', ['ToolsController', 'getCategories']);
$klein->respond('POST', '/admin/utensile', ['ToolsController', 'addTool']);
$klein->respond('DELETE', '/admin/utensile', ['ToolsController', 'removeTool']);
$klein->respond('DELETE', '/admin/utensile/segnalazione', ['ToolsController', 'removeAlertTool']);
$klein->respond('POST', '/admin/categoria', ['ToolsController', 'addCategory']);

// User

$klein->respond('POST', '/user/gruppo', ['GroupController', 'joinGroup']);
$klein->respond('DELETE', '/user/gruppo', ['GroupController', 'leaveGroup']);


/*
 * UTILS
 ****************/

// Match all endpoints to add Content-Type header
$klein->respond(function($req, $res) {
    $res->header('Content-Type', 'application/json');
});

// handle errors
$klein->onHttpError(function ($code, $router) {
    if($code == 404)
        $router->response()->body(json_encode(['error' => 'Not Found', 'code' => 404]));
    elseif ($code >= 400 && $code < 500)
        $router->response()->body(json_encode(['error' => 'User error', 'code' => $code]));
    elseif ($code >= 500 && $code <= 599)
        $router->response()->body(json_encode(['error' => 'Internal Server Error', 'code' => $code]));
});

$klein->dispatch();
