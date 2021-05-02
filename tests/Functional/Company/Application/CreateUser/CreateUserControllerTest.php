<?php
declare(strict_types=1);

namespace App\Tests\Functional\Company\Application\CreateUser;

use App\Common\Domain\ValueObject\Title;
use App\Common\Domain\ValueObject\Uuid;
use App\Company\Application\User\CreateUser\CreateUserRequest;
use App\Company\Domain\User\User;
use App\Company\Domain\User\UserRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class CreateUserControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private ?UserRepositoryInterface $userRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = static::createClient();

        $this->userRepository = self::$container->get(UserRepositoryInterface::class);
    }

    protected function tearDown(): void
    {
        $this->userRepository = null;

        parent::tearDown();
    }

    public function testItCanCreateAUser()
    {
        $this->client->request('POST', '/user', [CreateUserRequest::NAME => 'testing', CreateUserRequest::TITLE => Title::MR]);

        $result = json_decode($this->client->getResponse()->getContent(), true);

        self::assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
        self::assertArrayHasKey('newUserId', $result);

        $userCreated = $this->userRepository->findById(new Uuid($result['newUserId']));

        self::assertInstanceOf(User::class, $userCreated);
    }

    public function testItCanShowNameViolation()
    {
        $this->client->request('POST', '/user', [CreateUserRequest::TITLE => Title::MR]);

        $result = json_decode($this->client->getResponse()->getContent(), true);

        self::assertEquals(Response::HTTP_BAD_REQUEST, $this->client->getResponse()->getStatusCode());
        self::assertArrayHasKey(CreateUserRequest::NAME , $result);
    }

    public function testItCanShowTitleViolation()
    {
        $this->client->request('POST', '/user', [CreateUserRequest::NAME => 'test']);

        $result = json_decode($this->client->getResponse()->getContent(), true);

        self::assertEquals(Response::HTTP_BAD_REQUEST, $this->client->getResponse()->getStatusCode());
        self::assertArrayHasKey(CreateUserRequest::TITLE, $result);
    }

    public function testItCanShowNewFieldViolation()
    {
        $this->client->request('POST', '/user', [CreateUserRequest::NAME => 'testing', CreateUserRequest::TITLE => Title::MR, 'newField' => 'violation']);

        $result = json_decode($this->client->getResponse()->getContent(), true);

        self::assertEquals(Response::HTTP_BAD_REQUEST, $this->client->getResponse()->getStatusCode());
        self::assertArrayHasKey('newField', $result);
    }
}
