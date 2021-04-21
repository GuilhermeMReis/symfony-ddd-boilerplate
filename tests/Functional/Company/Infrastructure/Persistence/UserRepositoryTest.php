<?php
declare(strict_types=1);

namespace App\Tests\Functional\Company\Infrastructure\Persistence;

use App\Common\Domain\ValueObject\Title;
use App\Common\Domain\ValueObject\Uuid;
use App\Company\Domain\User\User;
use App\Company\Domain\User\UserRepositoryInterface;
use App\Company\Infrastructure\Persistence\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase
{
    private ?UserRepository $userRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->bootKernel();

        $this->userRepository = self::$container->get(UserRepositoryInterface::class);
    }

    protected function tearDown(): void
    {
        $this->userRepository = null;

        parent::tearDown();
    }

    public function testItCanCreateNewUser()
    {
        $userId = new Uuid;
        $user = new User($userId, 'name test', $title = new Title(Title::MR));

        $this->userRepository->save($user);

        $user = $this->userRepository->findById($userId);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals($userId->getValue(), $user->getId()->getValue());
        $this->assertTrue($title->equals($user->getTitle()));
    }
}
