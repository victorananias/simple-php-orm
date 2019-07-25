<?php


namespace SimpleORM;


class SimpleORM
{
    public static function create($connectionConfig)
    {
        return new QueryBuilder(
            Connection::start($connectionConfig)
        );
    }
}