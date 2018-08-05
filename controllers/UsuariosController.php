<?php

class UsuariosController {

    public function index() {
        $usuarios = App::get('db')->selectAll("usuarios");

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