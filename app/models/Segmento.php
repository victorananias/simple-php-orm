<?php

namespace App\Models;

use App\Core\App;

class Segmento
{
    public $id;
    public $nome;
    public $descricao;

    public static function find($id)
    {
        return App::get('db')->select("segmentos", 'App\Models\Segmento', compact('id'));
    }
}
