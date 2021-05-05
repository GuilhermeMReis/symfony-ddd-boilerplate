<?php
declare(strict_types=1);

namespace App\DataFixtures\Common;

use App\Common\Infrastructure\Security\UserSecurity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserSecurityFixtures extends Fixture
{
    public const USER_SECURITY_EMAIL = 'admin@test.com';

    public function __construct(private UserPasswordEncoderInterface $passwordEncoder) {}

    public function load(ObjectManager $manager)
    {
        $userSecurity = new UserSecurity();

        $userSecurity->setEmail(self::USER_SECURITY_EMAIL);
        $userSecurity->setPassword($this->passwordEncoder->encodePassword($userSecurity, 'secret'));

        $manager->persist($userSecurity);
        $manager->flush();
    }
}
