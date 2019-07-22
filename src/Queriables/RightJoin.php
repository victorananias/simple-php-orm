<?php

namespace App\Queriables;

class RightJoin extends Join
{
    public function __toString()
    {
        return 'right '. parent::__toString();
    }

}
