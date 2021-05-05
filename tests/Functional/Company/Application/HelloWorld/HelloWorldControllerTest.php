<?php
declare(strict_types=1);

namespace App\Tests\Functional\Company\Application\HelloWorld;

use App\Tests\BaseWebTestCase;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class HelloWorldControllerTest extends BaseWebTestCase
{
    private KernelBrowser $client;

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = $this->createAuthenticatedClient();
    }

    public function testItCanFetchHelloWorldResult()
    {
        $this->client->request('GET', '/api/hello');

        $result = json_decode($this->client->getResponse()->getContent(), true);

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertArrayHasKey('hello', $result);
        $this->assertEquals('world', $result['hello']);
    }

    public function testItCanHandleHelloWorldCommand()
    {
        $this->client->request('POST', '/api/hello');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), $this->client->getResponse()->getContent());
    }
}
