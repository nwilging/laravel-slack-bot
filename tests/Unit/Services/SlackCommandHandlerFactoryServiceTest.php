<?php
declare(strict_types=1);

namespace Nwilging\LaravelSlackBotTests\Unit\Services;

use Illuminate\Contracts\Foundation\Application;
use Mockery\MockInterface;
use Nwilging\LaravelSlackBot\Contracts\SlackCommandHandlerContract;
use Nwilging\LaravelSlackBot\Services\SlackCommandHandlerFactoryService;
use Nwilging\LaravelSlackBotTests\TestCase;

class SlackCommandHandlerFactoryServiceTest extends TestCase
{
    protected MockInterface $laravel;

    protected SlackCommandHandlerFactoryService $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->laravel = \Mockery::mock(Application::class);
        $this->service = new SlackCommandHandlerFactoryService($this->laravel);
    }

    public function testRegisterAndGetHandlerSuccess()
    {
        $command = 'test';
        $handlerClass = 'App\\TestClass';

        $this->service->register($handlerClass, $command);

        $handlerMock = \Mockery::mock(SlackCommandHandlerContract::class);
        $this->laravel->shouldReceive('make')
            ->once()
            ->with($handlerClass)
            ->andReturn($handlerMock);

        $result = $this->service->getHandler($command);
        $this->assertSame($result, $handlerMock);
    }

    public function testRegisterAndGetHandlerFailsForMissingCommandHandler()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('No handler found for command invalid-command');

        $this->service->getHandler('invalid-command');
    }
}
