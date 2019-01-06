<?php

namespace App\Models;

use App\Core\App;

class Produto
{
    public $ProdutoID;
    public $SegmentoID;
    public $NmProduto;
    public $DtCadastro;


    public static function all()
    {
        return App::get('db')->selectAll("TblProduto", 'App\Models\Produto');
    }

    public function segmento()
    {
        return Segmento::find($this->SegmentoID);
    }
}
