<?php
declare(strict_types=1);

namespace App\Common\Infrastructure\Route;

use App\Common\Domain\Bus\Command\Command;
use App\Common\Domain\Bus\Command\CommandBus;
use App\Common\Domain\Bus\Query\QueryBus;
use App\Common\Domain\Bus\Query\Query;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class BaseApiController extends AbstractController
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
