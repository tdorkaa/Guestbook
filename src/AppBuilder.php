<?php

namespace Guestbook;

use Guestbook\Controller\HealthCheck;
use PDO;
use Slim\App;

class AppBuilder
{
    public static function build()
    {
        $app = new App;
        $container = $app->getContainer();

        self::setUpDb($container);
        self::setUpDependencies($container);
        self::setUpRoutes($app);

        return $app;
    }

    private static function setUpRoutes($app)
    {
        $app->get('/healthcheck', HealthCheck::class . ':healthcheck');
    }

    private static function setUpDb($container)
    {
        $container['pdo'] = function () {
            return new PDO('mysql:host=mysql;charset=utf8mb4',
                'academy',
                'academy',
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        };
    }

    private static function setUpDependencies($container)
    {
        $container[HealthCheck::class] = function ($container) {
            return new HealthCheck(
                $container['pdo']
            );
        };
    }
}