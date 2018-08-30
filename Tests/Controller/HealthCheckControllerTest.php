<?php

namespace Tests\Controller;

use PHPUnit\Framework\TestCase;

class HealthCheckControllerTest extends TestCase
{
    use WebTestCase;

    /**
     * @test
     */
    public function calls_HealthCheck_Returns200()
    {
        $response = $this->runApp('GET', '/healthcheck');
        $this->assertEquals(200, $response->getStatusCode());
    }
}