<?php
declare(strict_types=1);

namespace App\Tests\Functional\Common\Application\HelloWorld;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HelloWorldControllerTest extends WebTestCase
{
    public function testItCanFetchHelloWorldResult()
    {
        $client = static::createClient();

        $client->request('GET', '/hello');

        $result = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('hello', $result);
        $this->assertEquals('world', $result['hello']);
    }

    public function testItCanHandleHelloWorldCommand()
    {
        $client = static::createClient();

        $client->request('POST', '/hello');

        $this->assertEquals(200, $client->getResponse()->getStatusCode(), $client->getResponse()->getContent());
    }
}
