<?php

namespace Guestbook;

use Dotenv\Dotenv;
use Guestbook\Controller\Guestbook;
use Guestbook\Controller\HealthCheck;
use Guestbook\Dao\Messages;
use Slim\App;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;

class AppBuilder
{
    public static function build()
    {
        $app = new App;
        $container = $app->getContainer();

        self::loadEnv();
        self::setupTwig($container);
        self::setUpDb($container);
        self::setUpDependencies($container);
        self::setUpRoutes($app);

        return $app;
    }


    public static function loadEnv()
    {
        $dotenvFile = 'development.env';

        $dotenv = new Dotenv(__DIR__ . '/../config', $dotenvFile);
        $dotenv->load();
    }

    private static function setupTwig($container)
    {
        $container['twig'] = function ($container) {
            $view = new Twig(__DIR__ . "/../view/", [
                'cache' => false
            ]);

            // Instantiate and add Slim specific extension
            $basePath = rtrim(str_ireplace('index.php', '', $container->get('request')->getUri()->getBasePath()), '/');
            $view->addExtension(new TwigExtension($container->get('router'), $basePath));

            return $view;
        };
    }

    private static function setUpDb($container)
    {
        $container['pdo'] = function () {
            return (new PdoFactory())->getPDO();
        };
    }

    private static function setUpDependencies($container)
    {
        $container[HealthCheck::class] = function ($container) {
            return new HealthCheck(
                $container['pdo']
            );
        };

        $container[Guestbook::class] = function ($container) {
            return new Guestbook(
                new Messages($container['pdo']),
                $container['twig'],
                new InputValidator()
            );
        };
    }

    private static function setUpRoutes($app)
    {
        $app->get('/healthcheck', HealthCheck::class . ':healthcheck');
        $app->get('/guestbook', Guestbook::class . ':getMessages');
        $app->post('/guestbook/save', Guestbook::class . ':saveMessage');
    }
}