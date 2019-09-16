<?php

namespace SimpleORM\Tests\Unit;

use SimpleORM\Queriables\Insert;
use SimpleORM\Tests\TestCase;

class InsertTest extends TestCase
{
    /** @test */
    public function it_prepares_the_insert_query()
    {
        $insert = new Insert('mytable', [
            'name' => 'this is the name',
            'type' => 'test'
        ]);

        $this->assertEquals($insert->__toString(), 'insert into mytable(name, type) values(?, ?)');
        $this->assertCount(2, $insert->params());
    }

    /** @test */
    public function it_prepares_multiples_inserts()
    {
        $insert = new Insert('mytable');

        $insert->addMultiple([
            ['name' => 'name 1', 'age' => 23],
            ['name' => 'name 2', 'age' => 21]
        ]);

        $this->assertEquals($insert->__toString(), 'insert into mytable(name, age) values(?, ?), (?, ?)');
        $this->assertCount(4, $insert->params());
    }
}
