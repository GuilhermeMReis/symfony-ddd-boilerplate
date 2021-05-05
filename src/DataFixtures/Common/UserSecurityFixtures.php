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
    public const USER_SECURITY_SECRET = 'secret';
    public const NON_ADMIN_USER_EMAIL = 'user@test.com';

    public function __construct(private UserPasswordEncoderInterface $passwordEncoder) {}

    public function load(ObjectManager $manager)
    {
        $userSecurity = new UserSecurity();

        $userSecurity->setEmail(self::USER_SECURITY_EMAIL);
        $userSecurity->setPassword($this->passwordEncoder->encodePassword($userSecurity, self::USER_SECURITY_SECRET));
        $userSecurity->setRoles(['ROLE_ADMIN', 'ROLE_USER']);

        $manager->persist($userSecurity);

        $userSecurity = new UserSecurity();

        $userSecurity->setEmail(self::NON_ADMIN_USER_EMAIL);
        $userSecurity->setPassword($this->passwordEncoder->encodePassword($userSecurity, self::USER_SECURITY_SECRET));
        $userSecurity->setRoles(['ROLE_USER']);

        $manager->persist($userSecurity);
        $manager->flush();
    }
}
