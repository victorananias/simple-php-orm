<?php

namespace App\Core\Database\Queriable;

class LeftJoin extends Join
{
    public function __toString()
    {
        return 'left '. parent::__toString();
    }

}
