<?php

namespace Tests\Feature;

use Tests\TestCase;

class QueryBuilderTest extends TestCase
{
    /** @test */
    public function it_executes_a_simple_select()
    {
        $result = db()->testing()->from('mytable')->all();

        $this->assertEquals($result['query'], 'select * from mytable');
        $this->assertCount(0, $result['params']);
    }

    /** @test */
    public function it_selects_specified_columns()
    {
        $result = db()->testing()
            ->select('id', 'name')
            ->from('mytable')
            ->get();

        $this->assertEquals($result['query'], 'select id, name from mytable');
    }

    /** @test */
    public function it_orders_the_select()
    {
        $result = db()->testing()
            ->from('mytable')
            ->orderBy('name')
            ->orderBy('id')
            ->get();

        $this->assertEquals($result['query'], 'select * from mytable order by name, id');
    }

    /** @test */
    public function it_selects_with_where_conditions()
    {   
        $result = db()->testing()
            ->from('mytable')
            ->where('id', 2)
            ->where('name', 'like', 'eita')
            ->get();

        $this->assertEquals($result['query'], 'select * from mytable where id = ? and name like ?');
        $this->assertCount(2, $result['params']);
    }

    /** @test */
    public function it_inserts_the_given_data()
    {
        $result = db()->testing()->table('mytable')->create([
            'name' => 'this is the name',
            'type' => 'test'
        ]);

        $this->assertEquals($result['query'], 'insert into mytable(name, type) values(?, ?)');
        $this->assertCount(2, $result['params']);
    }
}
