<?php
declare(strict_types=1);

namespace App\Common\Domain\Route;

use App\Common\Infrastructure\CQRS\Command\Command;
use App\Common\Infrastructure\CQRS\Command\CommandBus;
use App\Common\Infrastructure\CQRS\Query\QueryBus;
use App\Common\Infrastructure\CQRS\Query\Query;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class BaseController extends AbstractController
{
    public function __construct(
        private QueryBus $queryBus,
        private CommandBus $commandBus
    ) {}

    protected function query(Query $query): JsonResponse
    {
        return $this->json($this->queryBus->handle($query));
    }

    protected function command(Command $command): JsonResponse
    {
        $this->commandBus->dispatch($command);

        return new JsonResponse('', JsonResponse::HTTP_OK);
    }
}
