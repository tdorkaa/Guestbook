<?php
namespace Guestbook\Controller;


use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;

class Guestbook
{

    /**
     * @var \Guestbook\Dao\Messages
     */
    private $messagesDao;

    /**
     * @var Twig
     */
    private $twig;

    public function __construct(\Guestbook\Dao\Messages $messagesDao, Twig $twig)
    {
        $this->messagesDao = $messagesDao;
        $this->twig = $twig;
    }

    public function getMessages(Request $request, Response $response, array $args)
    {
        $messages = $this->messagesDao->listMessages();
        $this->twig->render($response, 'guestbook.html.twig', ['messages' => $messages]);
    }
}