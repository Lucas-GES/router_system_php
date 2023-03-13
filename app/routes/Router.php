<?php
namespace app\routes;
use app\helpers\Request;
use app\helpers\Uri;

class Router
{
    const CONTROLLER_NAMESPACE = 'app\\controllers';
    public static function load(string $controller, string $method)
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

            $controllerInstance->$method((object)$_REQUEST);

        } catch (\Throwable $th) {
            echo $th->getMessage();
        }
    }
    public static function routes():array
    {
        return [
            'get' => [
                '/' => fn() => self::load('HomeController', 'index'),
                '/contact' => fn() => self::load('ContactController', 'index'),
            ],
            'post' => [
                '/contact' => fn() => self::load('ContactController', 'store'),
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
            $routes = self::routes();
            $request = Request::get();
            $uri = Uri::get('path');

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