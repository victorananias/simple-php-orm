<?php

namespace App\Tests\Unit;

use App\Queriables\Join;
use App\Queriables\LeftJoin;
use App\Queriables\InnerJoin;
use App\Queriables\RightJoin;
use App\Queriables\FullJoin;
use App\Tests\TestCase;

class JoinTest extends TestCase
{
    /** @test */
    public function it_makes_a_simple_join()
    {
        $join = new Join('mytable');
        $join->on('product_id', 'x.id');

        $this->assertEquals('join mytable on product_id = x.id', $join->__toString());
    }

    /** @test */
    public function it_makes_joins_with_multiple_conditions()
    {
        $join = new Join('mytable');
        $join->on('product_id', 'x.id');
        $join->on('type_id', 't.id');

        $this->assertEquals('join mytable on product_id = x.id and type_id = t.id', $join->__toString());
    }

    /** @test */
    public function it_accepts_operators()
    {
        $join = new Join('mytable');
        $join->on('product_id', '=', 'x.id');
        $join->on('type_id', '<>', 't.id');

        $this->assertEquals('join mytable on product_id = x.id and type_id <> t.id', $join->__toString());
    }

    /** @test */
    public function it_accepts_wheres()
    {
        $join = new Join('mytable');

        $join->on('product_id', '=', 'x.id');
        $join->where('value', '>', 30);

        $this->assertEquals('join mytable on product_id = x.id and value > ?', $join->__toString());
        $this->assertCount(1, $join->params());
    }
    
    /** @test */
    public function it_can_be_left()
    {
        $leftJoin = new LeftJoin('mytable as t');

        $leftJoin->on('t.id', 'product_id');

        $this->assertEquals('left join mytable as t on t.id = product_id', $leftJoin->__toString());
    }
    
    /** @test */
    public function it_can_be_right()
    {
        $rightJoin = new RightJoin('mytable as t');

        $rightJoin->on('t.id', 'product_id');

        $this->assertEquals('right join mytable as t on t.id = product_id', $rightJoin->__toString());
    }

    /** @test */
    public function it_can_be_inner()
    {
        $innerJoin = new InnerJoin('mytable as t');

        $innerJoin->on('t.id', 'product_id');

        $this->assertEquals('inner join mytable as t on t.id = product_id', $innerJoin->__toString());
    }

    /** @test */
    public function it_can_be_full()
    {
        $fullJoin = new FullJoin('mytable as t');

        $fullJoin->on('t.id', 'product_id');

        $this->assertEquals('full join mytable as t on t.id = product_id', $fullJoin->__toString());
    }

}
