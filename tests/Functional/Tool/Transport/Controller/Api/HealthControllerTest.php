<?php

declare(strict_types=1);

namespace App\Tests\Functional\Tool\Transport\Controller\Api;

use App\General\Transport\Utils\Tests\WebTestCase;
use App\Log\Application\Resource\LogRequestResource;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

/**
 * Class HealthControllerTest
 *
 * @package App\Tests
 */
class HealthControllerTest extends WebTestCase
{
    private string $baseUrl = self::API_URL_PREFIX . '/health';

    /**
     * @testdox Test that health route returns success response.
     *
     * @throws Throwable
     */
    public function testThatHealthRouteReturns200(): void
    {
        $client = $this->getTestClient();

        $client->request('GET', $this->baseUrl);
        $response = $client->getResponse();
        static::assertSame(Response::HTTP_OK, $response->getStatusCode(), "Response:\n" . $response);
    }

    /**
     * @testdox Test that health route does not make request log.
     *
     * @throws Throwable
     */
    public function testThatHealthRouteDoesNotMakeRequestLog(): void
    {
        $resource = static::getContainer()->get(LogRequestResource::class);
        static::assertInstanceOf(LogRequestResource::class, $resource);
        $expectedLogCount = $resource->count();
        $client = $this->getTestClient();

        $client->request('GET', $this->baseUrl);
        static::assertSame($expectedLogCount, $resource->count());
    }
}