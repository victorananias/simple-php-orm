<?php

require(__DIR__.'/../core/database/Where.php');

use PHPUnit\Framework\TestCase;

class WhereTest extends TestCase
{
    public function testSimpleWhere()
    {
        $where = new \App\Core\Database\Where();

        $where->add('id', 2);

        $this->assertEquals($where->sql(), 'WHERE id = ?');
        $this->assertCount(1, $where->params());

        $where->add('product_id', 2);

        $this->assertEquals($where->sql(), 'WHERE id = ? AND product_id = ?');
        $this->assertCount( 2, $where->params());
    }

    public function testOperatorWhere()
    {
        $where = new \App\Core\Database\Where();

        $where->add('id','>', 2);

        $this->assertEquals($where->sql(), 'WHERE id > ?');
    }
}