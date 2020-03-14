<?
use controllers;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$request = isset($_GET['r']) ? $_GET['r'] : '';
$parts = explode('/', $request);

//que engamos un request 

$controller = 'main';
$action = 'index';

if(!empty($parts[0])){
    $controller = $parts[0];
}

if(!empty($parts[1])){
    $action = $parts[1];
}

$controller = ucfirst($controller);

spl_autoload_register(function ($controller) {
    $controller = str_replace('\\', '/', $controller);
    include dirname(__FILE__).'/'.$controller . '.php';
});

$pathController = 'controllers\\';
$contollerClass = $pathController.ucfirst($controller);

$class = new $contollerClass();
$action = 'action'.ucwords($action);

$class->$action();
