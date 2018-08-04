<?php

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
      return $this->routes[$requestType][$uri];
    }
    throw new Exception("URI solicitada não existe.");
  }

}
