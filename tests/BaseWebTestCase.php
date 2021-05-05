<?php
declare(strict_types=1);

namespace App\Tests;

use App\DataFixtures\Common\UserSecurityFixtures;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BaseWebTestCase extends WebTestCase
{
    protected function createAuthenticatedClient($username = UserSecurityFixtures::USER_SECURITY_EMAIL, $password = UserSecurityFixtures::USER_SECURITY_SECRET): KernelBrowser
    {
        if (static::$booted) {
            $client = static::$kernel->getContainer()->get('test.client');
        } else {
            $client = static::createClient();
        }

        $client->request(
            'POST',
            '/api/login_check',
            array(),
            array(),
            array('CONTENT_TYPE' => 'application/json'),
            json_encode(array(
                'username' => $username,
                'password' => $password,
            ))
        );

        $data = json_decode($client->getResponse()->getContent(), true);

        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $data['token']));

        return $client;
    }
}
