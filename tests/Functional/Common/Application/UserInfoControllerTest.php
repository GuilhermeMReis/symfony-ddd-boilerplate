<?php
declare(strict_types=1);

namespace App\Tests\Functional\Common\Application;

use App\Common\Infrastructure\Security\UserSecurity;
use App\Common\Infrastructure\Security\UserSecurityRepository;
use App\Tests\BaseWebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Response;

class UserInfoControllerTest extends BaseWebTestCase
{
    private ?KernelBrowser $client;
    private ?UserSecurityRepository $userRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = $this->createAuthenticatedClient();

        $this->userRepository = self::$container->get(UserSecurityRepository::class);
    }

    protected function tearDown(): void
    {
        $this->userRepository = null;
        $this->client = null;

        parent::tearDown();
    }

    public function testItCanFetchALoggedInUser()
    {
        $this->client->request('GET', '/api/user-info');

        $result = json_decode($this->client->getResponse()->getContent(), true);

        self::assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        self::assertArrayHasKey('username', $result);

        $user = $this->userRepository->findOneBy(['email' => $result['username']]);

        self::assertInstanceOf(UserSecurity::class, $user);
    }
}
