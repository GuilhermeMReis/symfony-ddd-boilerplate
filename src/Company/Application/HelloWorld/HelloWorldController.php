<?php
declare(strict_types=1);

namespace App\Company\Application\HelloWorld;

use App\Common\Infrastructure\Route\BaseApiController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class HelloWorldController extends BaseApiController
{
    /**
     * @Route("/api/hello", name="hello_world", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function index(): Response
    {
        return $this->query(new HelloWorldQuery('world'));
    }

    /**
     * @Route("/api/hello", name="hello_world_command", methods={"POST"})
     * @IsGranted("ROLE_USER")
     */
    public function handle(): Response
    {
        return $this->command(new HelloWorldCommand('world'));
    }
}
