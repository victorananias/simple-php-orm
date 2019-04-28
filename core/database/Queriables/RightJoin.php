<?php

namespace App\Core\Database\Queriable;

class RightJoin extends Join
{
    public function __toString()
    {
        return 'right '. parent::__toString();
    }

}
