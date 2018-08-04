<?php

class Router {
  protected $routes = [];

  public static function carregar($arquivo) {
    $router = new self;
    $router->routes = require($arquivo);
    return $router;
  }

  public function direcionar($uri) {
    if(array_key_exists($uri, $this->routes)) {
      return $this->routes[$uri];
    }
    throw new Exception("URI solicitada não existe.");
  }

}
