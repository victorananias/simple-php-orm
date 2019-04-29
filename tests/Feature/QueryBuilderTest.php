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
            ->from('mytable', 'm')
            ->get();

        $this->assertEquals($result['query'], 'select id, name from mytable as m');
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
    public function it_joins_selects()
    {
        $result = db()->testing()
            ->from('mytable', 'm')
            ->join('table as t', 't.id', 'm.table_id')
            ->get();

        $this->assertEquals($result['query'], 'select * from mytable as m join table as t on t.id = m.table_id');

        $this->assertCount(0, $result['params']);
    }

    /** @test */
    public function it_joins_selects_with_conditions()
    {
        $result = db()->testing()
            ->from('mytable', 'm')
            ->join('table as t', function ($join) {
                $join->on('t.id', 'm.table_id');
                $join->where('t.value', '>', 2);
            })
            ->get();

        $this->assertEquals($result['query'], 'select * from mytable as m join table as t on t.id = m.table_id and t.value > ?');
        $this->assertCount(1, $result['params']);
    }

    /** @test */
    public function group_by()
    {
        $result = db()->testing()->select('id', 'name')
            ->from('mytable')
            ->groupBy('id', 'name')
            ->get();

        $this->assertEquals('select id, name from mytable group by id, name', $result['query']);

    }

    /** @test */
    public function it_accepts_unordered_functions_when_selecting()
    {
        $result = db()->testing()
            ->where('id', '!=', 2)
            ->groupBy('id', 'name')
            ->from('mytb')
            ->select('id', 'name')
            ->orderBy('id')
            ->get();

        $this->assertEquals('select id, name from mytb where id != ? group by id, name order by id', $result['query']);
    }

    /** @test */
    public function it_inserts_the_given_data()
    {
        $result = db()->testing()->table('mytable')->create([
            'name' => 'this is the name',
            'type' => 'test'
        ]);

        $this->assertEquals('insert into mytable(name, type) values(?, ?)', $result['query']);
        $this->assertCount(2, $result['params']);
    }
}
