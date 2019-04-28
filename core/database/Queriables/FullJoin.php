<?php

namespace App\Core\Database\Queriable;

class FullJoin extends Join
{
    public function __toString()
    {
        return 'full '. parent::__toString();
    }

}
