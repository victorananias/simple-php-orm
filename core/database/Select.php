<?php

namespace App\Core\Database;


class Select
{
    protected $columns = [];

    public function __construct(...$columns)
    {
        $this->columns = $columns;
    }
}