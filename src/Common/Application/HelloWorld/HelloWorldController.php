<?php
declare(strict_types=1);

namespace App\Common\Application\HelloWorld;

use App\Common\Domain\Route\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HelloWorldController extends BaseController
{
    #[Route('/hello', name: 'hello_world', methods: ['GET'])]
    public function index(): Response
    {
        return $this->query(new HelloWorldQuery('world'));
    }
}
