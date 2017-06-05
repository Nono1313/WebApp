<?php

session_start();
 
// Check if the timeout field exists.
if(isset($_SESSION['timeout'])) {
    // See if the number of seconds since the last
    // visit is larger than the timeout period.
    $duration = time() - (int)$_SESSION['timeout'];
    if($duration > $timeout) {
        // Destroy the session and restart it.
        session_destroy();
        session_start();
    }
}
 
// Update the timout field with the current time.
$_SESSION['timeout'] = time();

$error = '';

function customError($errno, $errstr) {
  echo "[$errno] $errstr";
}
set_error_handler("customError");

require_once('../controller/AppController.php');

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    //Routing Usuarios
    	//Insert
    	$r->addRoute(['GET', 'POST'], '/users/register[/{nombre:\.+}/{password:\.+}]', 'UserController/createUser');
    	//Update
    	$r->addRoute(['GET', 'POST'], '/users/update/{nombre}', 'UserController/updateUser');
    	//delete
    	$r->addRoute(['GET'], '/users/delete/{nombre}', 'UserController/deleteUser');
    	//read
    	$r->addRoute('GET', '/users[/view/{nombre}]', 'UserController/readUser');	
    //page 1
    	$r->addRoute('GET', '/PAGE_1', 'AppController/IndexRole1');
    //page 2
    	$r->addRoute('GET', '/PAGE_2', 'AppController/IndexRole2');
    //page 3
    	$r->addRoute('GET', '/PAGE_3', 'AppController/IndexRole3');
    // iniciar sesion
    $r->addRoute('GET', '/login', 'AppController/Login');
    $r->addRoute('POST', '/loginCheck', 'AppController/LoginCheck');


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