<?php

namespace Tests\Feature;

require __DIR__ . '/../../index.php';

use PHPUnit\Framework\TestCase;

class QueryBuilderTest extends TestCase
{
    public function testSelect()
    {
        $sql = db()->from('mytable')
            ->where('id', 2)
            ->where('name', 'like', 'eita')
            ->toSql();

        $this->assertEquals($sql, 'select * from mytable where id = ? and name like ?');
    }

    public function testSelect2()
    {
        $sql = db()->testing()->table('ToDos')->create([
            'Name' => 'teste 222'
        ]);

        dd($sql);
    }
}
