<?php

function dd($dados) {
    echo "<pre>";
    print_r($dados);
    echo "</pre>";
    die();
}

function response(array $data = []) {
    echo json_encode($data);
    return;
}

function db($table) {
    return \App\Core\App::get('db')->table($table);
}