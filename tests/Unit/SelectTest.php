<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Core\Database\Queriable\Select;
use App\Core\Database\Queriable\Where;
use App\Core\Database\Queriable\OrderBy;

class SelectTest extends TestCase
{
    /** @test */
    public function it_builds_a_simple_select()
    {
        $select = new Select();
        $select->from('mytable');
        $this->assertEquals($select->__toString(), 'select * from mytable');
    }

    /** @test */
    public function it_accepts_an_array_of_columns()
    {
        $select = new Select(['id','name']);

        $select->from('mytable');
        
        $this->assertEquals($select->__toString(), 'select id, name from mytable');
    }

    /** @test */
    public function it_accepts_where_conditions()
    {
        $select = new Select(['id']);
        $select->from('mytable');

        $where = new Where;
        $where->add('product_id', 2);
        $where->add('name', 'like', 'john');

        $select->where($where);
        
        $this->assertEquals($select->__toString(), 'select id from mytable where product_id = ? and name like ?');
        $this->assertCount(2, $select->params());
    }


    /** @test */
    public function it_accepts_order_by()
    {
        $select = new Select();
        
        $select->from('mytable');

        $orderBy = new OrderBy('name', 'desc');

        $select->orderBy($orderBy);

        $this->assertEquals($select->__toString(), 'select * from mytable order by name desc');
    }
}
