<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Core\Database\Queriable\Delete;
use App\Core\Database\Queriable\Where;

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
