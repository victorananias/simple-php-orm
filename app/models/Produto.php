<?php

namespace App\Models;

use App\Core\App;

class Produto
{
    public $id;
    public $segmento_id;
    public $nome;
    public $data;


    public static function all()
    {
        return App::get('db')->selectAll("produtos", 'App\Models\Produto');
    }

    public function segmento()
    {
        return Segmento::find($this->segmento_id);
    }
}
