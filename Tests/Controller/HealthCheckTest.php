<?php

namespace Tests\Controller;

use Guestbook\Controller\HealthCheck;
use PHPUnit\Framework\TestCase;
use Slim\Http\Request;
use Slim\Http\Response;

class HealthCheckTest extends TestCase
{

    /**
     * @test
     */
    public function healthcheck_givenPdo_querySelect1()
    {
        $mockPDO = $this->createMock(\PDO::class);
        $mockPDO->expects($this->once())
            ->method('query')
            ->with('SELECT 1');

        $healthCheck = new HealthCheck($mockPDO);

        $healthCheck->healthcheck($this->createMock(Request::class),
            $this->createMock(Response::class), []);
    }
}