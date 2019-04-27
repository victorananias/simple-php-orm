<?php

namespace Tests\Unit;

require __DIR__ . '/../../core/database/Where.php';

use PHPUnit\Framework\TestCase;

class WhereTest extends TestCase
{
    public function testSimpleWhere()
    {
        $where = new \App\Core\Database\Where();

        $where->add('id', 2);

        $this->assertEquals($where->sql(), 'where id = ?');
        $this->assertCount(1, $where->params());

        $where->add('product_id', 2);

        $this->assertEquals($where->sql(), 'where id = ? and product_id = ?');
        $this->assertCount(2, $where->params());
    }

    public function testOperator()
    {
        $where = new \App\Core\Database\Where();

        $where->add('id', '>', 2);

        $this->assertEquals($where->sql(), 'where id > ?');
        $this->assertCount(1, $where->params());
    }

    public function testMultiple()
    {
        $where = new \App\Core\Database\Where();

        $where->addMultiple([
            'id' => 2,
            'name like' => '%johndoe%',
            'product_id is not null',
            'date >' => '2019-04-02'
        ]);

        $this->assertEquals($where->sql(), 'where id = ? and name like ? and product_id is not null and date > ?');
        $this->assertCount(3, $where->params());
    }

    public function testEmpty()
    {
        $where = new \App\Core\Database\Where();

        $this->assertEquals($where->sql(), '');
        $this->assertCount(0, $where->params());
    }

    public function testIsNull()
    {
        $where = new \App\Core\Database\Where();

        $where->add('column is null');

        $this->assertEquals($where->sql(), 'where column is null');
        $this->assertCount(0, $where->params());
    }
}
