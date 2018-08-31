<?php
namespace Guestbook\Controller;


use DateTime;
use Guestbook\Dao\Messages;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;

class Guestbook
{

    /**
     * @var Messages
     */
    private $messagesDao;

    /**
     * @var Twig
     */
    private $twig;

    public function __construct(Messages $messagesDao, Twig $twig)
    {
        $this->messagesDao = $messagesDao;
        $this->twig = $twig;
    }

    public function getMessages(Request $request, Response $response, array $args)
    {
        $messages = $this->messagesDao->listMessages();
        $this->twig->render($response, 'guestbook.html.twig', ['messages' => $messages]);
    }

    public function saveMessage(Request $request, Response $response, array $args)
    {
        $name = $request->getParam('name');
        $email = $request->getParam('email');
        $message = $request->getParam('message');
        $date = date('Y-m-d H:i:s');

        $this->messagesDao->saveMessage($name, $email, $message, $date);

        $response->withRedirect('/guestbook');
    }
}