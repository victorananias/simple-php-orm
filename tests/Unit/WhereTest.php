<?php

namespace SimpleORM\Tests\Unit;

use SimpleORM\Queriables\Where;
use SimpleORM\Tests\TestCase;

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

    public function it_checks_whether_a_condition_exists()
    {
        $where = new Where();

        $this->assertEquals('', $where->__toString());
        $this->assertCount(0, $where->params());
    }

    public function it_allows_where_is_null_conditions()
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

    /** @test */
    public function it_allows_where_in_coditions()
    {
        $where = new Where();

        $where->add('id', 'in', [2, 3, 4]);
        $where->add('product_id', 2);

        $this->assertEquals('id in (?, ?, ?) and product_id = ?', $where->conditions());
        $this->assertCount(4, $where->params());
    }

    /** @test */
    public function it_allows_where_not_in_coditions()
    {
        $where = new Where();

        $where->add('id', 'not in', [2, 3, 4]);
        $where->add('product_id', 2);

        $this->assertEquals('id not in (?, ?, ?) and product_id = ?', $where->conditions());
        $this->assertCount(4, $where->params());
    }
}
