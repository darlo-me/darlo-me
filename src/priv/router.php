<?php
set_include_path(__DIR__);

require_once('libs/utils.php');
require_once('libs/Exceptions.php');
require_once('libs/Config.php');
require_once('libs/Request.php');

function fatal_error_handler($errno, $errstr, $errfile, $errline) {
    throw new Exception("$errno: $errfile:$errline: $errstr");
}
#set_error_handler("fatal_error_handler");

function extract_path(string $p) {
    if(($page = realpath(dirname($p))) === FALSE)
        return false;

    $page = $page . '/' . basename($p);

    if(($rootdir = realpath(__DIR__ . '/../pub')) === FALSE)
        return false;
    
    if(substr($page, 0, strlen($rootdir)) !== $rootdir)
        return false;

    if(($page = substr($page, strlen($rootdir))) === FALSE)
        return false;

    return $page;
}

function sec_check_request($request, $config, $controller) {
    $method = $request->server['REQUEST_METHOD'] ?? 'GET';
    switch($method) {
        case 'POST':
        case 'PUT':
            return false;
        case 'HEAD':
        case 'GET':
            break;
        default:
            throw new \Exception("Unrecognized method $method");
    }
    
    return true;
}

function get_controller_from_request_page($page) {
    if(substr($page, 0, 1) !== '/') {
        if(!($page = extract_path($page))) {
            throw new \Exception("Cannot get path to PHP_SELF");
        }
    }

    $pages = [
        '/index.html.php'    => 'controllers/index.php',
        '/projects.html.php' => 'controllers/projects.php',
        '/readings.html.php' => 'controllers/readings.php',
    ];
    
    if(substr($page, 0, strlen('/blog-post/')) === '/blog-post/') {
        $controller = @include('controllers/blog.php');
        $controller->page = substr($page, strlen('/blog-post/'));
        return $controller;
    } else if(isset($pages[$page])) {
        return @include($pages[$page]);
    } else {
        return '';
    }
}

$config  = new Config();
$request = new Request($_SERVER, $_FILES, $_POST, $_GET);
unset($_SERVER, $_FILES, $_POST, $_GET);

try {
    try {
        $controller = get_controller_from_request_page($request->server['PHP_SELF']);

        if(!$controller) {
            throw new HTTPException(404);
        }

        if(!sec_check_request($request, $config, $controller)) {
            throw new HTTPException(403);
        }

        foreach($controller->execute($request, $config) as $data) {
            echo $data;
        }
    } catch(HTTPException $e) {
        throw $e;
    } catch(Exception $e) {
        throw new HTTPException(500, $e);
    }
} catch(HTTPException $e) {
    http_response_code($e->getCode());
    if($e->getMessage()) {
        echo $e->getMessage();
    }
    exit(1);
}
