<?php
require_once('../controller/AppController.php');

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    //Routing Usuarios
    	//read
    	$r->addRoute('GET', '/users[/{nombre}]', 'UserController/readUser');
    	//Insert
    	$r->addRoute(['GET', 'POST'], '/users/register/{nombre:\.+}/{password:\.+}', 'UserController/createUser');
    	//Update
    	$r->addRoute(['GET', 'POST'], '/users/update/{id:\.+}/{nombre:\.+}/{password:\.+}', 'UserController/createUser');
    	//delete
    	$r->addRoute(['POST'], '/users/delete/{id:\.+}', 'UserController/deleteUser');
    //page 1
    	$r->addRoute('GET', '/PAGE_1', 'AppController/IndexRole1');
    //page 2
    	$r->addRoute('GET', '/PAGE_2', 'AppController/IndexRole2');
    //page 3
    	$r->addRoute('GET', '/PAGE_3', 'AppController/IndexRole3');
    // iniciar sesion
    $r->addRoute('GET', '/login', 'AppController/Login');

    // Salida
    $r->addRoute('GET', '/logout', 'AppController/Logout');
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        echo('<h1>404 error: Not Found</h1>');
        error_log(print_r('404 error: No encontrado', TRUE));
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        // ... call $handler with $vars
        list($class, $method) = explode("/", $handler, 2);
    	call_user_func_array(array(new $class, $method), $vars);
        break;
}