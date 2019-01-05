<?php

namespace App\Core;

use \Exception;

class Router {
    protected $routes = [
        'POST' => [],
        'GET' => [],
        'DELETE' => [],
        'PUT' => []
    ];

    public static function carregar($arquivo) {
        $router = new self;
        require $arquivo;
        return $router;
    }

    public function post($rota, $controller) {
        $this->routes['POST'][$rota] = $controller;
    }

    public function get($rota, $controller) {
        $this->routes['GET'][$rota] = $controller;
    }

    public function put($rota, $controller) {
        $this->routes['PUT'][$rota] = $controller;
    }

    public function delete($rota, $controller) {
        $this->routes['DELETE'][$rota] = $controller;
    }

    public function direcionar($uri, $requestType) {

        if(array_key_exists($uri, $this->routes[$requestType])) {
            $dados = explode('@', $this->routes[$requestType][$uri]);

            $controller = $dados[0];
            $metodo = $dados[1];

            return $this->executarAcao($controller, $metodo);
        }

        throw new Exception("URI solicitada não existe.");
    }

    protected function executarAcao($controller, $metodo) {
        $controller = "App\\Controllers\\{$controller}";
        $controller = new $controller;

        if(!method_exists($controller, $metodo)) {
            throw new Exception("Método não encontrado.");
        }

        return $controller->$metodo();
    }



}
