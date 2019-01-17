<?php

namespace App\Controllers;

use App\Core\App;
use App\Models\Produto;

class ProdutosController
{
    public function index()
    {
        $produtos = Produto::all();
        return view('index', compact('produtos'));
    }

    public function create()
    {
        $segmentos = App::get('db')->selectAll("segmentos", 'App\Models\Segmento');
        return view('create', compact('segmentos'));
    }

    public function edit()
    {
        $produto = App::get('db')->select("produtos", 'App\Models\Produto', [
            'id' => "{$_GET['produto']}"
        ]);

        $segmentos = App::get('db')->selectAll("segmentos", 'App\Models\Segmento');

        return view('edit', compact(['produto', 'segmentos']));
    }

    public function store()
    {
        App::get('db')->insert('produtos', [
            'nome' => $_POST['nome'],
            'segmento_id' => $_POST['segmento_id']
        ]);
        
        return redirecionar('');
    }

    public function update()
    {
        App::get('db')->update(
            'produtos',
            ['id' => $_POST['id']],
            [
                'nome' => $_POST['nome'],
                'segmento_id' => $_POST['segmento_id']
            ]
        );

        return redirecionar('produtos');
    }

    public function destroy()
    {
        App::get('db')->delete('produtos', ['id' => $_GET['produto']]);
        echo json_encode(['mensagem' => 'Deletado.']);
    }
}
