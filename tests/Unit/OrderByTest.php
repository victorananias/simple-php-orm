<?php

namespace App\Tests\Unit;

use App\Queriables\OrderBy;
use App\Tests\TestCase;

class OrderByTest extends TestCase
{
    /** @test */
    public function it_returns_an_order_by()
    {
        $orderBy = new OrderBy('name');

        $this->assertEquals('order by name', $orderBy->__toString());
    }
    
    /** @test */
    public function it_accepts_the_direction()
    {
        $orderBy = new OrderBy('name', 'desc');

        $this->assertEquals('order by name desc', $orderBy->__toString());
    }
    
    /** @test */
    public function it_accepts_multiple_orders()
    {
        $orderBy = new OrderBy('name', 'desc');

        $orderBy->add('id');

        $this->assertEquals('order by name desc, id', $orderBy->__toString());
    }

}
