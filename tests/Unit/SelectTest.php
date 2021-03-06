<?php

namespace SimpleORM\Tests\Unit;

use SimpleORM\Queriables\Select;
use SimpleORM\Queriables\Where;
use SimpleORM\Queriables\OrderBy;
use SimpleORM\Queriables\Join;
use SimpleORM\Queriables\GroupBy;
use SimpleORM\Queriables\LeftJoin;
use SimpleORM\Tests\TestCase;

class SelectTest extends TestCase
{
    /** @test */
    public function it_builds_a_simple_select()
    {
        $select = new Select();
        $select->from('mytable');
        $this->assertEquals('select * from mytable', $select->__toString());
    }

    /** @test */
    public function it_accepts_multiple_columns()
    {
        $select = new Select();

        $select->columns('id', 'name');

        $select->from('mytable');

        $this->assertEquals('select id, name from mytable', $select->__toString());
    }

    /** @test */
    public function it_accepts_where_conditions()
    {
        $select = new Select();
        $select->columns('id');
        $select->from('mytable');

        $where = new Where;
        $where->add('product_id', 2);
        $where->add('name', 'like', 'john');

        $select->where($where);

        $this->assertEquals('select id from mytable where product_id = ? and name like ?', $select->__toString());
        $this->assertCount(2, $select->params());
    }

    /** @test */
    public function it_accepts_order_by()
    {
        $select = new Select();

        $select->from('mytable');

        $orderBy = new OrderBy('name', 'desc');

        $select->orderBy($orderBy);

        $this->assertEquals('select * from mytable order by name desc', $select->__toString());
    }

    /** @test */
    public function tables_can_have_aliases()
    {
        $select = new Select();
        $select->from('mytable', 't');

        $this->assertEquals('select * from mytable as t', $select->__toString());
    }

    /** @test */
    public function it_accepts_joins()
    {
        $select = new Select();
        $select->from('mytable', 'm');

        $join1 = new Join('table2 as t2');
        $join1->on('t2.id', 'm.table2_id');

        $select->join($join1);

        $join2 = new Join('table3 as t3');
        $join2->on('t3.id', 'm.table3_id');
        $join2->where('t3.value', '>', 2);

        $select->join($join2);

        $this->assertEquals(
            'select * from mytable as m join table2 as t2 on t2.id = m.table2_id join table3 as t3 on t3.id = m.table3_id and t3.value > ?',
            $select->__toString()
        );
        $this->assertCount(1, $select->params());
    }

    /** @test */
    public function it_can_be_grouped()
    {
        $select = new Select;

        $select->from('mytable');

        $groupBy = new GroupBy('id', 'name');
        $groupBy->having('count(product_id)', '>', 5);

        $select->groupBy($groupBy);

        $this->assertEquals('select * from mytable group by id, name having count(product_id) > ?', $select->__toString());
        $this->assertCount(1, $select->params());
    }

    /** @test */
    public function it_can_be_complex()
    {
        $select = new Select();
        $select->columns('id', 'name', 'count(product_id) as products_count');
        
        $select->from('mytable', 'm');

        $join1 = new Join('table2 as t2');
        $join1->on('t2.id', 'm.table2_id');
        $join1->where('t2.id', '<>', 9);

        $join2 = new LeftJoin('table3 as t3');
        $join2->on('t3.id', 'm.table3_id');

        $where = new Where;
        $where->add('name', 'like', 'john');

        $groupBy = new GroupBy('id', 'name');
        $groupBy->having('count(product_id)', '>', 5);
        $orderBy = new OrderBy('name', 'desc');

        $select->groupBy($groupBy);
        $select->join($join1);
        $select->join($join2);
        $select->where($where);
        $select->orderBy($orderBy);

        $this->assertEquals(
            'select id, name, count(product_id) as products_count '
            . 'from mytable as m '
            . 'join table2 as t2 on t2.id = m.table2_id and t2.id <> ? '
            . 'left join table3 as t3 on t3.id = m.table3_id '
            . 'where name like ? '
            . 'group by id, name having count(product_id) > ? '
            . 'order by name desc',
            $select->__toString()
        );
    }
}
