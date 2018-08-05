<?php

namespace App\Core;

class Router {
    protected $routes = [
        'POST' => [],
        'GET' => []
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

    public function direcionar($uri, $requestType) {
        if(array_key_exists($uri, $this->routes[$requestType])) {
            return $this->executarAcao(
                /*
                |
                | explode()
                |
                | "explode" uma string e a transforma em um array
                |
                */
                /*
                |
                | ...
                |
                | splat operator converte cada item do array em argumentos
                | para a função sendo chamada.
                |
                */
                ...explode('@', $this->routes[$requestType][$uri])
            );
        }
        throw new Exception("URI solicitada não existe.");
    }

    protected function executarAcao($controller, $metodo) {
        /*
        |
        | \\
        |
        | caso seja usado somente um \ o php irá dar um "escaping":
        | não irá ignorar os {}.
        |
        */
        $controller = "App\\Controllers\\{$controller}";
        $controller = new $controller;

        if(!method_exists($controller, $metodo)) {
            throw new Exception("Método não encontrado.");
        }

        return $controller->$metodo();
    }



}
