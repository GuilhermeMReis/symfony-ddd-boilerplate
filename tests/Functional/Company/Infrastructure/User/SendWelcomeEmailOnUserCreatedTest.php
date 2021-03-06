<?php
declare(strict_types=1);

namespace App\Tests\Functional\Company\Infrastructure\User;

use App\Common\Domain\ValueObject\Title;
use App\Common\Domain\ValueObject\Uuid;
use App\Company\Domain\User\User;
use App\Company\Domain\User\UserRepositoryInterface;
use App\Company\Domain\User\UserWelcomeEmailSent;
use App\Company\Infrastructure\Persistence\UserRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SendWelcomeEmailOnUserCreatedTest extends KernelTestCase
{
    private ?UserRepository $userRepository;
    private EntityManager $em;

    protected function setUp(): void
    {
        parent::setUp();
        $this->bootKernel();

        $this->em = self::$container->get('doctrine.orm.entity_manager');
        $this->em->beginTransaction();

        $this->userRepository = self::$container->get(UserRepositoryInterface::class);
    }

    protected function tearDown(): void
    {
        $this->userRepository = null;
        $this->em->rollback();

        parent::tearDown();
    }

    public function testItCanCreateNewUserAndCheckIfForAValidWelcomeEmailSentFlag()
    {
        $userId = new Uuid;
        $user = new User($userId, 'name test', $title = new Title(Title::MR));

        $this->userRepository->save($user);

        $user = $this->userRepository->findById($userId);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($userId->getValue(), $user->getId()->getValue());
        $this->assertTrue($title->equals($user->getTitle()));
        $this->assertTrue($user->isFakeWelcomeEmailSent());
        $this->assertNotNull($user->getFakeEmailValidationId());
    }

    public function testItCanFireOffUserWelcomeEmailSentIntegrationEvent()
    {
        $userId = new Uuid;
        $user = new User($userId, 'name test', new Title(Title::MR));

        $this->userRepository->save($user);

        $user = $this->userRepository->findById($userId);

        $this->assertInstanceOf(User::class, $user);

        $transport = self::$container->get('messenger.transport.async');

        /** @var UserWelcomeEmailSent $integrationEvent */
        $integrationEvent = $transport->get()[0]->getMessage();

        $this->assertInstanceOf(UserWelcomeEmailSent::class, $integrationEvent);
        $this->assertEquals($userId->getValue(), $integrationEvent->userId);
    }
}
