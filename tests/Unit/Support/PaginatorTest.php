<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBotTests\Unit\Support;

use Nwilging\LaravelSlackBot\Support\Paginator;
use Nwilging\LaravelSlackBotTests\TestCase;

class PaginatorTest extends TestCase
{
    public function testWithSinglePage()
    {
        $items = [1, 2, 3];
        $paginator = new Paginator($items);

        $this->assertFalse($paginator->hasMorePages());
        $this->assertNull($paginator->nextCursor());
        $this->assertEquals([
            'items' => $items,
            'next_cursor' => null,
            'has_more_pages' => false,
        ], $paginator->toArray());
    }

    public function testWithMultiplePages()
    {
        $items = [1, 2, 3];
        $nextCursor = 'next-cursor';

        $paginator = new Paginator($items, $nextCursor);

        $this->assertTrue($paginator->hasMorePages());
        $this->assertSame($nextCursor, $paginator->nextCursor());
        $this->assertEquals([
            'items' => $items,
            'next_cursor' => $nextCursor,
            'has_more_pages' => true,
        ], $paginator->toArray());
    }
}
