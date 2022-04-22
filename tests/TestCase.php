<?php
declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
{
    public function tearDown(): void
    {
        if (class_exists('Mockery')) {
            if ($container = \Mockery::getContainer()) {
                $this->addToAssertionCount($container->mockery_getExpectationCount());
            }

            \Mockery::close();
        }

        parent::tearDown();
    }
}
