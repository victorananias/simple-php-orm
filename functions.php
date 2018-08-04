<?php

function dd($data) {
    echo "<pre>";
    die(var_dump($data));
    echo "</pre>";
}

function getPDO() {
    try {
        return new PDO("mysql:host=127.0.0.1;dbname=meubanco;charset=utf8", "user1", "user1");
    } catch(PDOException $exception) {
        dd($exception->getMessage());
    }
}