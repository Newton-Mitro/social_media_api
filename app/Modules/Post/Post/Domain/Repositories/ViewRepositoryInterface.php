<?php

namespace App\Modules\Post\Domain\Interfaces;

use App\Modules\Post\Domain\Entities\PostAggregate;
use Symfony\Component\HttpKernel\Event\ViewEvent;

interface ViewRepositoryInterface
{
    public function addView(PostAggregate $post, ViewEvent $view);
    public function removeView(PostAggregate $post, ViewEvent $view);
}
