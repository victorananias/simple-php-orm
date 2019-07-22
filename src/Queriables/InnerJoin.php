<?php

namespace App\Queriables;

class InnerJoin extends Join
{
    public function __toString()
    {
        return 'inner '. parent::__toString();
    }

}
