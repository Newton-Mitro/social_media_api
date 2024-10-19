<?php
namespace App\Features\Auth\Privacy\UseCases\Queries;

use App\Core\Bus\IQueryBus;
use App\Core\Bus\CommandHandler;
use App\Features\Auth\Privacy\UseCases\Queries\GetPrivacyQuery;
use App\Features\Auth\Privacy\Interfaces\PrivacyRepositoryInterface;

class GetPrivacyQueryHandler extends CommandHandler
{
    public function __construct(
        protected IQueryBus $queryBus,
        protected PrivacyRepositoryInterface $repository
    ) {
    }
    public function handle(GetPrivacyQuery $query): array
    {
        return $this->repository->getPrivacy();
    }
}