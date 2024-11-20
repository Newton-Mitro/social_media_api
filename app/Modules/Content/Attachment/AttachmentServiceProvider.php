<?php

namespace App\Modules\Content\Attachment;

use App\Modules\Content\Attachment\Domain\Repositories\AttachmentRepositoryInterface;
use App\Modules\Content\Attachment\Infrastructure\Repositories\AttachmentRepository;
use Illuminate\Support\ServiceProvider;


class AttachmentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $singletons = [
            AttachmentRepositoryInterface::class => AttachmentRepository::class,
        ];

        foreach ($singletons as $abstract => $concrete) {
            $this->app->singleton(
                $abstract,
                $concrete,
            );
        }
    }

    public function boot(): void {}
}
