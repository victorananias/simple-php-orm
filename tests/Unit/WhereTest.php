<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Core\Database\Queriable\Where;

class WhereTest extends TestCase
{
    public function testSimpleWhere()
    {
        $where = new Where();

        $where->add('id', 2);

        $this->assertEquals($where->__toString(), 'where id = ?');
        $this->assertCount(1, $where->params());

        $where->add('product_id', 2);

        $this->assertEquals($where->__toString(), 'where id = ? and product_id = ?');
        $this->assertCount(2, $where->params());
    }

    public function testOperator()
    {
        $where = new Where();

        $where->add('id', '>', 2);

        $this->assertEquals($where->__toString(), 'where id > ?');
        $this->assertCount(1, $where->params());
    }

    public function testMultiple()
    {
        $where = new Where();

        $where->addMultiple([
            'id' => 2,
            'name like' => '%johndoe%',
            'product_id is not null',
            'date >' => '2019-04-02'
        ]);

        $this->assertEquals($where->__toString(), 'where id = ? and name like ? and product_id is not null and date > ?');
        $this->assertCount(3, $where->params());
    }

    public function testEmpty()
    {
        $where = new Where();

        $this->assertEquals($where->__toString(), '');
        $this->assertCount(0, $where->params());
    }

    public function testIsNull()
    {
        $where = new Where();

        $where->add('column is null');

        $this->assertEquals($where->__toString(), 'where column is null');
        $this->assertCount(0, $where->params());
    }
}
