<?php
declare(strict_types=1);

namespace App\DataFixtures\Company;

use App\Company\Domain\User\User;
use App\Common\Domain\ValueObject\Uuid;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User(
            new Uuid(),
            'name'
        );

        $manager->persist($user);
        $manager->flush();
    }
}