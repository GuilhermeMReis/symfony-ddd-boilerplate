<?php
declare(strict_types=1);

namespace App\DataFixtures\Company;

use App\Common\Domain\ValueObject\Title;
use App\Company\Domain\User\User;
use App\Common\Domain\ValueObject\Uuid;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public const USER_TEST_ID = '3bf01954-abdc-11eb-b8fb-0242ac1a0004';

    public function load(ObjectManager $manager)
    {
        $user = new User(
            new Uuid(self::USER_TEST_ID),
            'Guilherme Reis',
            new Title(Title::MR)
        );

        $manager->persist($user);
        $manager->flush();
    }
}
