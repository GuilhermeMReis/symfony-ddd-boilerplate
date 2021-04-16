<?php
declare(strict_types=1);

namespace App\Common\Application\HelloWorld;

use App\Common\Domain\Route\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloWorldController extends BaseController
{
    #[Route('/hello', name: 'hello_world')]
    public function index(): Response
    {
        return new Response('Hello world', Response::HTTP_OK);
    }
}
