<?php
declare(strict_types=1);

namespace App\Tests\Functional\Company\Application\CreateUser;

use App\Common\Domain\ValueObject\Title;
use App\Common\Domain\ValueObject\Uuid;
use App\Company\Application\User\CreateUser\CreateUserRequest;
use App\Company\Domain\User\User;
use App\Company\Domain\User\UserRepositoryInterface;
use App\DataFixtures\Common\UserSecurityFixtures;
use App\Tests\BaseWebTestCase;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\HttpFoundation\Response;

class CreateUserControllerTest extends BaseWebTestCase
{
    private KernelBrowser $client;
    private ?UserRepositoryInterface $userRepository;
    private EntityManager $em;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = $this->createAuthenticatedClient();
        $this->client->disableReboot();

        $this->em = $this->client->getContainer()->get('doctrine.orm.entity_manager');
        $this->em->beginTransaction();

        $this->userRepository = self::$container->get(UserRepositoryInterface::class);
    }

    protected function tearDown(): void
    {
        $this->userRepository = null;
        $this->em->rollback();

        parent::tearDown();
    }

    public function testItCanCreateAUser()
    {
        $this->client->request('POST', '/api/user', [CreateUserRequest::NAME => 'testing', CreateUserRequest::TITLE => Title::MR]);

        $result = json_decode($this->client->getResponse()->getContent(), true);

        self::assertEquals(Response::HTTP_CREATED, $this->client->getResponse()->getStatusCode());
        self::assertArrayHasKey('newUserId', $result);

        $userCreated = $this->userRepository->findById(new Uuid($result['newUserId']));

        self::assertInstanceOf(User::class, $userCreated);
    }

    public function testItCanShowNameViolation()
    {
        $this->client->request('POST', '/api/user', [CreateUserRequest::TITLE => Title::MR]);

        $result = json_decode($this->client->getResponse()->getContent(), true);

        self::assertEquals(Response::HTTP_BAD_REQUEST, $this->client->getResponse()->getStatusCode());
        self::assertArrayHasKey(CreateUserRequest::NAME , $result);
    }

    public function testItCanShowTitleViolation()
    {
        $this->client->request('POST', '/api/user', [CreateUserRequest::NAME => 'test']);

        $result = json_decode($this->client->getResponse()->getContent(), true);

        self::assertEquals(Response::HTTP_BAD_REQUEST, $this->client->getResponse()->getStatusCode());
        self::assertArrayHasKey(CreateUserRequest::TITLE, $result);
    }

    public function testItCanShowNewFieldViolation()
    {
        $this->client->request('POST', '/api/user', [CreateUserRequest::NAME => 'testing', CreateUserRequest::TITLE => Title::MR, 'newField' => 'violation']);

        $result = json_decode($this->client->getResponse()->getContent(), true);

        self::assertEquals(Response::HTTP_BAD_REQUEST, $this->client->getResponse()->getStatusCode());
        self::assertArrayHasKey('newField', $result);
    }

    public function testItFailsOnNonAdminUser()
    {
        $client = $this->createAuthenticatedClient(UserSecurityFixtures::NON_ADMIN_USER_EMAIL);

        $client->request('POST', '/api/user', [CreateUserRequest::NAME => 'testing', CreateUserRequest::TITLE => Title::MR, 'newField' => 'violation']);

        self::assertEquals(Response::HTTP_FORBIDDEN, $client->getResponse()->getStatusCode());
    }
}
