<?php

namespace App\Core\Bus;

interface ICommandBus
{
    public function dispatch(Command $command): mixed;

    public function register(array $map): void;
}
