<?php

function dd($dados)
{
    echo "<pre>";
    print_r($dados);
    echo "</pre>";
    die();
}

function response($data = [])
{
    echo json_encode($data);
    return;
}

function back()
{
    return redirect(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null);
}

function redirect($url = null)
{
    if (empty($url)) {
        header("HTTP/1.0 404 Not Found");
        echo '404 Not Found';
        return;
    }

    header("Location: {$url}");
    return;
}

function post($index) {
    return isset($_POST[$index]) ? $_POST[$index] : null;
}

function get($index) {
    return isset($_GET[$index]) ? $_GET[$index] : null;
}

function request($index = null) {
    if (!$index) {
        return [
            'post' => $_POST,
            'get' => $_GET,
        ];
    }

    return get($index) ?: post($index);
}