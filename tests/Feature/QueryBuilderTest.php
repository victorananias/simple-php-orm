<?php

namespace SimpleORM\Tests\Feature;

use SimpleORM\QueryBuilder;
use SimpleORM\Tests\TestCase;
use \PDO;

class QueryBuilderTest extends TestCase
{
    private $dsn = 'sqlite:testing.sqlite3';

    public function tearDown(): void
    {
        if (file_exists(explode(':', $this->dsn)[1])) {
            unlink(explode(':', $this->dsn)[1]);
        }

        parent::tearDown();
    }

    /** @test */
    public function it_executes_a_simple_select()
    {
        $result = $this->db()->toSql()->from('mytable')->all();

        $this->assertEquals($result['query'], 'select * from mytable');
        $this->assertCount(0, $result['params']);
    }

    /** @test */
    public function it_selects_specified_columns()
    {
        $result = $this->db()->toSql()
            ->select('id', 'name')
            ->from('mytable', 'm')
            ->get();

        $this->assertEquals($result['query'], 'select id, name from mytable as m');
    }

    /** @test */
    public function it_orders_the_select()
    {
        $result = $this->db()->toSql()
            ->from('mytable')
            ->orderBy('name')
            ->orderBy('id')
            ->get();

        $this->assertEquals($result['query'], 'select * from mytable order by name, id');
    }

    /** @test */
    public function it_selects_with_where_conditions()
    {
        $result = $this->db()->toSql()
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
        $result = $this->db()->toSql()
            ->from('mytable', 'm')
            ->join('table as t', 't.id', 'm.table_id')
            ->get();

        $this->assertEquals($result['query'], 'select * from mytable as m join table as t on t.id = m.table_id');

        $this->assertCount(0, $result['params']);
    }

    /** @test */
    public function it_joins_selects_with_conditions()
    {
        $result = $this->db()->toSql()
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
        $result = $this->db()->toSql()->select('id', 'name')
            ->from('mytable')
            ->groupBy('id', 'name')
            ->get();

        $this->assertEquals('select id, name from mytable group by id, name', $result['query']);
    }

    /** @test */
    public function it_accepts_unordered_functions_when_selecting()
    {
        $result = $this->db()->toSql()
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
        $result = $this->db()->toSql()->table('mytable')->create([
            'name' => 'this is the name',
            'type' => 'test'
        ]);

        $this->assertEquals('insert into mytable(name, type) values(?, ?)', $result['query']);
        $this->assertCount(2, $result['params']);
    }

    /** @test */
    public function it_deletes()
    {
        $result = $this->db()->toSql()->table('mytb')->where('id', 3)->delete();

        $this->assertEquals('delete from mytb where id = ?', $result['query']);
        $this->assertCount(1, $result['params']);
    }

    /** @test */
    public function it_updates()
    {
        $result = $this->db()
            ->toSql()
            ->table('mytb')
            ->where([
                'id' => 2
            ])->update([
                'name' => 2,
                'type' => 'new type'
            ]);

        $this->assertEquals('update mytb set name = ?, type = ? where id = ?', $result['query']);
        $this->assertCount(3, $result['params']);
    }

    /** @test */
    public function it_limits()
    {
        $result = $this->db()->toSql()->from('mytb')->limit(2)->get();
        $this->assertEquals('select top 2 * from mytb', $result['query']);
    }

    /** @test */
    public function it_fetchs_the_count()
    {
        $result = $this->db()->toSql()->from('mytb')->count();

        $this->assertEquals('select top 1 count(*) from mytb', $result['query']);
    }

    /** @test */
    public function it_can_select_the_first_row()
    {
        $result = $this->db()->toSql()->from('mytb')->first();

        $this->assertEquals('select top 1 * from mytb', $result['query']);
    }

    public function it_can_select_only_one_column()
    {
    }

    private function db()
    {
        return new QueryBuilder(new PDO($this->dsn));
    }
}
