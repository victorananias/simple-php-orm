<?php

namespace SimpleORM\Tests\Unit;

use SimpleORM\Queriables\Where;
use SimpleORM\Queriables\Update;
use SimpleORM\Tests\TestCase;

class UpdateTest extends TestCase
{
    /** @test */
    public function it_updates_where()
    {
        $update = new Update();

        $update->table('mytb');

        $where = new Where;
        $where->add('id', 2);

        $update->where($where);

        $update->set([
            'name' => 'new name',
            'type' => 2
        ]);

        $this->assertEquals('update mytb set name = ?, type = ? where id = ?', $update->__toString());
        $this->assertCount(3, $update->params());
    }
}
