<?php
set_include_path(__DIR__);

require_once('libs/utils.php');
require_once('libs/Exceptions.php');
require_once('libs/Config.php');
require_once('libs/Request.php');

require_once('Module.php');

function fatal_error_handler($errno, $errstr, $errfile, $errline) {
    throw new Exception("$errno: $errfile:$errline: $errstr" . PHP_EOL . print_r(array_reverse(debug_backtrace()), true) );
}
set_error_handler("fatal_error_handler");

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
    $pages = [
        '/index.html.php'    => 'controllers/index.php',
        '/posts.html.php'    => 'controllers/posts.php',
        '/projects.html.php' => 'controllers/projects.php',
        '/readings.html.php' => 'controllers/readings.php',
        '/software.html.php' => 'controllers/software.php',
    ];

    if(isset($pages[$page])) {
        $controller = include($pages[$page]);
    } else if(substr($page, 0, strlen('/posts/')) === '/posts/') {
        $controller = include('controllers/post.php');
        $controller->page = substr($page, strlen('/posts/'));
    } else {
        return '';
    }

    return $controller;
}

$config  = new Config('conf/secrets.json');
$request = new Request($_SERVER, $_FILES, $_POST, $_GET);
unset($_SERVER, $_FILES, $_POST, $_GET);

try {
    try {
        $currentPage = $request->server['PHP_SELF'];
        if(substr($currentPage, 0, 1) !== '/') {
            if(!($currentPage = extract_path($currentPage))) {
                throw new \Exception("Cannot get path to PHP_SELF");
            }
        }
        $controller = get_controller_from_request_page($currentPage);

        if(!$controller) {
            throw new HTTPException(500);
        }

        if(!sec_check_request($request, $config, $controller)) {
            throw new HTTPException(403);
        }

        Module::$globals = [ // Some variables that will be needed by most views
            'currentPage' => $currentPage,
        ];
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
    if($e->getPrevious()) {
        throw $e->getPrevious();
    }
    exit(1);
}
