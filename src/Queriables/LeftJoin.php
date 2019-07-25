<?php

namespace SimpleORM\Queriables;

class LeftJoin extends Join
{
    public function __toString()
    {
        return 'left '. parent::__toString();
    }

}
