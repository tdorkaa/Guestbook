<?php

namespace Guestbook;

use Slim\App;
use Slim\Http\Request;
use Slim\Http\Response;

class AppBuilder
{
    public static function build()
    {
        $app = new App;

        $app->get('/healthcheck', function (Request $request, Response $response, array $args) {
            return $response;
        });

        return $app;
    }
}