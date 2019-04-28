<?php

namespace App\Core\Database\Queriable;

class InnerJoin extends Join
{
    public function __toString()
    {
        return 'inner '. parent::__toString();
    }

}
