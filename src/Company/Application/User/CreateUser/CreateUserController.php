<?php
declare(strict_types=1);

namespace App\Company\Application\User\CreateUser;

use App\Common\Domain\ValueObject\Title;
use App\Common\Domain\ValueObject\Uuid;
use App\Common\Infrastructure\Route\BaseApiController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateUserController extends BaseApiController
{
    /**
     * @Route("/api/user", name="create_user", methods={"POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function handleRequest(CreateUserRequest $userRequest): Response
    {
        if (false === $userRequest->validate()->isValid) return $this->json($userRequest->validate()->violations, Response::HTTP_BAD_REQUEST);

        $newUserId = new Uuid();

        $this->command(new CreateUserCommand(
            $newUserId,
            $userRequest->request->get(CreateUserRequest::NAME),
            new Title($userRequest->request->get(CreateUserRequest::TITLE))
        ));

        return $this->json(['newUserId' => $newUserId->getValue()], Response::HTTP_CREATED);
    }
}
