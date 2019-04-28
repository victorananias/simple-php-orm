<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Core\Database\Queriable\OrderBy;

class OrderByTest extends TestCase
{
    /** @test */
    public function it_returns_an_order_by()
    {
        $orderBy = new OrderBy('name');

        $this->assertEquals($orderBy->__toString(), 'order by name');
    }
    
    /** @test */
    public function it_accepts_the_direction()
    {
        $orderBy = new OrderBy('name', 'desc');

        $this->assertEquals($orderBy->__toString(), 'order by name desc');
    }
    
    /** @test */
    public function it_accepts_multiple_orders()
    {
        $orderBy = new OrderBy('name', 'desc');

        $orderBy->add('id');

        $this->assertEquals($orderBy->__toString(), 'order by name desc, id');
    }

}
