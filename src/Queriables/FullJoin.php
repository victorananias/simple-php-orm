<?php

namespace SimpleORM\Queriables;

class FullJoin extends Join
{
    public function __toString()
    {
        return 'full '. parent::__toString();
    }

}
