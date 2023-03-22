<?php
namespace app\routes;
use app\helpers\Request;
use app\helpers\Uri;

class Router
{
    const CONTROLLER_NAMESPACE = 'app\\controllers';
    public static function load(string $controller, string $method, $id = null, $data = null)
    {
        try {
            //Verify if controller exists
            $controllerNamespace = self::CONTROLLER_NAMESPACE.'\\'.$controller;
            if(!class_exists($controllerNamespace)){
                throw new \Exception("O Controller {$controller} não existe");
            }

            $controllerInstance = new $controllerNamespace;

            //Verify if the method exists in the controller
            if(!method_exists($controllerInstance, $method)){
                throw new \Exception("O método {$method} não existe no Controller {$controller}");
            }

            //Verify if the $id is not null then pass as params to controller
            if(isset($id)){
                $controllerInstance->$method((object) $_REQUEST, $id);
            }else if(isset($data)){
                $controllerInstance->$method((object) $_REQUEST, null, $data);
            }else{
                $controllerInstance->$method((object)$_REQUEST);
            }

        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }
    public static function routes($id = null, $data = null):array
    {
        return [
            'get' => [
                '/' => fn() => self::load('LoginController', 'index'),
                '/sign' => fn() => self::load('LoginController', 'sign'),
                '/logout' => fn() => self::load('LoginController', 'logout'),
                '/home' => fn() => self::load('HomeController', 'index')
            ],
            'post' => [
                '/sign' => fn() => self::load('LoginController', 'signup', $data),
                '/login' => fn() => self::load('LoginController', 'login', $data)
            ],
            'put' => [

            ],
            'delete' => [

            ],
        ];
    }   

    public static function execute()
    {
        try {
            //$routes = self::routes();
            $request = Request::get();
            $uri = Uri::get('path');
            $path = explode('/', $uri);
            $data = json_decode(file_get_contents('php://input'));
            echo($data);
            //Verify if exist params in the uri than pass as params
            if(isset($path[2]) && is_numeric($path[2])){
                $routes = self::routes($path[2], null);
            }else if(isset($data)){
                $routes = self::routes(null, $data);
            }else{
                $routes = self::routes();
            }

            //Verify if the route exists
            if(!isset($routes[$request])){
                throw new \Exception('A rota não existe');
            }

            //Verify if the route uri exists
            if(!array_key_exists($uri, $routes[$request])){
                throw new \Exception('A rota não existe');
            }

            $router = $routes[$request][$uri];

            //Verify if the route is using arrow function
            if(!is_callable($router)){
                throw new \Exception("Route {$uri} is not callable");
            }
            $router();
        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }
}