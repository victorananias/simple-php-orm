<?php

namespace App\Core;

use \Exception;

class Router
{
    protected $routes = [
        'POST' => [],
        'GET' => [],
        'DELETE' => [],
        'PUT' => []
    ];

    public static function load($arquivo)
    {
        $router = new self;
        require $arquivo;
        return $router;
    }

    public function post($rota, $controller)
    {
        $this->routes['POST'][$rota] = $controller;
    }

    public function get($rota, $controller)
    {
        $this->routes['GET'][$rota] = $controller;
    }

    public function put($rota, $controller)
    {
        $this->routes['PUT'][$rota] = $controller;
    }

    public function delete($rota, $controller)
    {
        $this->routes['DELETE'][$rota] = $controller;
    }

    public function redirect($uri, $requestType)
    {
        if (array_key_exists($uri, $this->routes[$requestType])) {
            return $this->executeAction(
                ...explode('@', $this->routes[$requestType][$uri])
            );
        }
        throw new Exception('URI solicitada não existe.');
    }

    protected function executeAction($controller, $method)
    {
        $controller = "App\\Controllers\\{$controller}";
        $controller = new $controller;

        if (!method_exists($controller, $method)) {
            throw new Exception('Método não encontrado.');
        }

        return $controller->$method();
    }
}
