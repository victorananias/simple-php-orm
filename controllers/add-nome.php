<?php


App::get('db')->insert('usuarios', [
    'nome' => $_POST['nome']
]);

header("Location: /");