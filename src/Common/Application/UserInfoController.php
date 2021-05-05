<?php
declare(strict_types=1);

namespace App\Common\Application;

use App\Common\Infrastructure\Route\BaseApiController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class UserInfoController extends BaseApiController
{
    /**
     * @Route("/api/user-info", name="api_user_info", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function index(UserInterface $userSecurity): Response
    {
        return $this->json(['username' => $userSecurity->getUsername()], Response::HTTP_OK);
    }
}
