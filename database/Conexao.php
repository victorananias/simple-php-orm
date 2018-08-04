<?php

class Conexao {

  public static function iniciar() {
    try {
        return new PDO("mysql:host=127.0.0.1;dbname=meubanco;charset=utf8", "user1", "user1");
    } catch(PDOException $exception) {
        die($exception->getMessage());
    }
  }
}
