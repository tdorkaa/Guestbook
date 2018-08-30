<?php

namespace Guestbook\Controller;

use Slim\Http\Request;
use Slim\Http\Response;

class HealthCheck
{
    public function healthcheck(Request $request, Response $response, array $args)
    {
        return $response;
    }
}