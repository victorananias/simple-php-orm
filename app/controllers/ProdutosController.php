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

    public function cadastro()
    {
        $segmentos = App::get('db')->selectAll("TblSegmento", 'App\Models\Segmento');
        return view('cadastro', compact('segmentos'));
    }

    public function edicao()
    {
        $produto = App::get('db')->select("TblProduto", 'App\Models\Produto', [
            'ProdutoID' => "{$_GET['produto']}"
        ]);

        $segmentos = App::get('db')->selectAll("TblSegmento", 'App\Models\Segmento');

        return view('edicao', compact(['produto', 'segmentos']));
    }

    public function store()
    {
        App::get('db')->insert('TblProduto', [
            'NmProduto' => $_POST['NmProduto'],
            'SegmentoID' => $_POST['SegmentoID']
        ]);
        
        return redirecionar('');
    }

    public function update()
    {
        App::get('db')->update(
            'TblProduto',
            ['ProdutoID' => $_POST['ProdutoID']],
        [
            'NmProduto' => $_POST['NmProduto'],
            'SegmentoID' => $_POST['SegmentoID']
        ]
        );

        return redirecionar('');
    }

    public function deletar()
    {
        App::get('db')->delete('TblProduto', ['ProdutoID' => $_GET['ProdutoID']]);
        echo json_encode(['mensagem' => 'Deletado.']);
    }
}
