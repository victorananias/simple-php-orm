<?php

namespace Tests\Unit;

use App\Core\Database\Queriable\Insert;

use Tests\TestCase;

class InsertTest extends TestCase
{
    public function testInserting()
    {
        $insert = new Insert('mytable', [
            'name' => 'this is the name',
            'type' => 'test'
        ]);

        $this->assertEquals($insert->__toString(), 'insert into mytable(name, type) values(?, ?)');
        $this->assertCount(2, $insert->params());
    }

    public function testMultiple()
    {
        $insert = new Insert('mytable');

        $insert->addMultiple([
            ['name' => 'name 1'],
            ['name' => 'name 2']
        ]);

        $this->assertEquals($insert->__toString(), 'insert into mytable(name) values(?); insert into mytable(name) values(?)');
        $this->assertCount(2, $insert->params());
    }
}
