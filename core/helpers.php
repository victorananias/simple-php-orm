<?php

if (!function_exists('dd')) {
    function dd($dados)
    {
        echo '<pre>';
        print_r($dados);
        echo '</pre>';
        die();
    }
}

if (!function_exists('response')) {
    function response($data = [])
    {
        echo json_encode($data);
        return;
    }
}

if (!function_exists('back')) {
    function back()
    {
        return redirect(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null);
    }
}

if (!function_exists('redirect')) {
    function redirect($url = null)
    {
        if (empty($url)) {
            header('HTTP/1.0 404 Not Found');
            echo '404 Not Found';
            return;
        }

        header("Location: {$url}");
        return;
    }
}

if (!function_exists('post')) {
    function post($index)
    {
        return isset($_POST[$index]) ? $_POST[$index] : null;
    }
}

if (!function_exists('get')) {
    function get($index)
    {
        return isset($_GET[$index]) ? $_GET[$index] : null;
    }
}

if (!function_exists('request')) {
    function request($index = null)
    {
        if (!$index) {
            return [
                'post' => $_POST,
                'get' => $_GET,
            ];
        }

        return get($index) ?: post($index);
    }
}
