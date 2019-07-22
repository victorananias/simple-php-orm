<?php

namespace App\Tests\Unit;

use App\Queriables\GroupBy;
use App\Tests\TestCase;

class GroupByTest extends TestCase
{

    /** @test */
    public function it_returns_a_group_by()
    {
        $groupBy = new GroupBy('id', 'name');

        $this->assertEquals('group by id, name', $groupBy->__toString());
    }

    /** @test */
    public function it_can_have_conditions()
    {
        $groupBy = new GroupBy('id', 'name');

        $groupBy->having('count(product_id)', '>', 10);

        $this->assertEquals('group by id, name having count(product_id) > ?', $groupBy->__toString());
        $this->assertCount(1, $groupBy->params());
    }
}
