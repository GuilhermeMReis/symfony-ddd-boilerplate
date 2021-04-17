<?php
declare(strict_types=1);

namespace App\Common\Application\HelloWorld;

use App\Common\Infrastructure\Route\BaseApiController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloWorldApiController extends BaseApiController
{
    #[Route('/hello', name: 'hello_world', methods: ['GET'])]
    public function index(): Response
    {
        return $this->query(new HelloWorldQuery('world'));
    }

    #[Route('/hello', name: 'hello_world_command', methods: ['POST'])]
    public function handle(): Response
    {
        return $this->command(new HelloWorldCommand('world'));
    }
}
