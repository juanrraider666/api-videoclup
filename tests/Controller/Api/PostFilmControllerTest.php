<?php


use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class PostFilmControllerTest extends WebTestCase
{
    public function testNotAuthorized()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/films',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'X-AUTH-TOKEN' => 'FILMREPO'
            ],
            '{"title":""}'
        );
        $this->assert(Response::HTTP_UNAUTHORIZED, $client->getResponse()->getStatusCode());
    }

    public function testCreateFilmInvalidData()
    {
        $client = static::createClient();
        $this->sendRequest($client, ['title' => '']);
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
    }

    public function testCreateFilmEmptyData()
    {
        $client = static::createClient();
        $this->sendRequest($client, []);
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
    }

    public function testSuccess()
    {
        $client = static::createClient();
        $this->sendRequest($client, ['title' => 'El imperio final']);
        $this->assertEquals(Response::HTTP_CREATED, $client->getResponse()->getStatusCode());
    }

    private function sendRequest(KernelBrowser $client, array $json)
    {
        $client->request(
            'POST',
            '/api/films',
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_X-AUTH-TOKEN' => 'FILMREPO'
            ],
            json_encode($json)
        );
    }
}