<?php


$app['db']->insert('usuarios', [
    'nome' => $_POST['nome']
]);

header("Location: /");