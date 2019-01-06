<?php

namespace App\Models;

use App\Core\App;

class Segmento
{
    public $SegmentoID;
    public $NmSegmento;
    public $Descricao;

    public static function find($SegmentoID)
    {
        $segmento = App::get('db')->select("TblSegmento", 'App\Models\Segmento', compact('SegmentoID'));
        return $segmento;
    }
}
