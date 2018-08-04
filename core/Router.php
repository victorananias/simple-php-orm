<?php

class Router {
  protected $routes = [];

  public function registrar($rotas) {
    $this->routes = $rotas;
  }

  public function direcionar($uri) {
    if(array_key_exists($uri, $this->routes)) {
      return $this->routes[$uri];
    }
    throw new Exception("URI solicitada não existe.");
  }

}
