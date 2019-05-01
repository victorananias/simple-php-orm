<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Core\Database\Queriable\Where;

class WhereTest extends TestCase
{

    /** @test */
    public function it_creates_conditions()
    {
        $where = new Where();

        $where->add('id', 2);

        $this->assertEquals('where id = ?', $where->__toString());
        $this->assertCount(1, $where->params());

        $where->add('product_id', 2);

        $this->assertEquals('where id = ? and product_id = ?', $where->__toString());
        $this->assertCount(2, $where->params());
    }

    /** @test */
    public function it_accepts_an_operator()
    {
        $where = new Where();

        $where->add('id', '>', 2);

        $this->assertEquals('where id > ?', $where->__toString());
        $this->assertCount(1, $where->params());
    }


    /** @test */
    public function it_accepts_an_array_of_conditions()
    {
        $where = new Where();

        $where->addMultiple([
            'id' => 2,
            'name like' => '%johndoe%',
            'product_id is not null',
            'date >' => '2019-04-02'
        ]);

        $this->assertEquals('where id = ? and name like ? and product_id is not null and date > ?', $where->__toString());
        $this->assertCount(3, $where->params());
    }

    public function testEmpty()
    {
        $where = new Where();

        $this->assertEquals('', $where->__toString());
        $this->assertCount(0, $where->params());
    }

    public function testIsNull()
    {
        $where = new Where();

        $where->add('column is null');

        $this->assertEquals('where column is null', $where->__toString());
        $this->assertCount(0, $where->params());
    }

    /** @test */
    public function it_returns_only_the_conditions() 
    {
        $where = new Where();

        $where->add('id', 2);
        $where->add('product_id', 2);

        $this->assertEquals('id = ? and product_id = ?', $where->conditions());
        $this->assertCount(2, $where->params());
    }
}
