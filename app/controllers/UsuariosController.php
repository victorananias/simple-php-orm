<?php

namespace App\Controllers;

use App\Core\App;
use App\Models\Usuario;

class UsuariosController {

    public function index() {
        $usuarios = App::get('db')->selectAll("usuarios", Usuario::class);
        /*
        |
        | compact()
        |
        | compacta as variáveis correspondentes as strings passadas
        | e as compacta em um array.
        |
        */
        return view('usuarios', compact('usuarios'));
    }

    public function store() {
        App::get('db')->insert('usuarios', [
            'nome' => $_POST['nome']
        ]);
        
        return redirecionar('usuarios');
    }
}