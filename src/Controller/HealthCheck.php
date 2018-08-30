<?php

namespace Guestbook\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class HealthCheck
{
    private $PDO;

    public function __construct(\PDO $PDO)
    {

        $this->PDO = $PDO;
    }

    public function healthcheck(Request $request, Response $response, array $args)
    {
        $this->PDO->query('SELECT 1');
        return $response;
    }
}