<?php

namespace App\Tests\Unit;

use App\Queriables\Delete;
use App\Queriables\Where;
use App\Tests\TestCase;

class DeleteTest extends TestCase
{
    /** @test */
    public function it_returns_a_delete_query()
    {
        $delete = new Delete();
        $delete->from('mytb');

        $where = new Where();

        $where->add('name', '<>', 'John');

        $delete->where($where);

        $this->assertEquals('delete from mytb where name <> ?', $delete->__toString());
        $this->assertCount(1, $delete->params());
    }

}
