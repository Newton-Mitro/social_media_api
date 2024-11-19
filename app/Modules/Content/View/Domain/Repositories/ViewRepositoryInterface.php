<?php

namespace App\Modules\Content\View\Domain\Repositories;

use App\Modules\Content\Domain\Entities\PostAggregate;
use Symfony\Component\HttpKernel\Event\ViewEvent;

interface ViewRepositoryInterface
{
    public function addView(PostAggregate $post, ViewEvent $view);
    public function removeView(PostAggregate $post, ViewEvent $view);
}
