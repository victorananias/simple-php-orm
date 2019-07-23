<?php

namespace SimpleORM\Queriables;

class InnerJoin extends Join
{
    public function __toString()
    {
        return 'inner '. parent::__toString();
    }

}
