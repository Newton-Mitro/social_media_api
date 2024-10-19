<?php

namespace App\Core\Bus;

use Illuminate\Bus\Dispatcher;

class IlluminateCommandBus implements ICommandBus
{
    public function __construct(
        protected Dispatcher $bus,
    ) {}

    public function dispatch(Command $command): mixed
    {
        return $this->bus->dispatch($command);
    }

    public function register(array $map): void
    {
        $this->bus->map($map);
    }
}
