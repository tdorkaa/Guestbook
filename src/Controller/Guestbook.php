<?php

namespace Guestbook\Controller;

use Guestbook\Dao\Messages;
use Guestbook\InputFilter;
use Guestbook\InputValidator;
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

    /**
     * @var InputValidator
     */
    private $validator;

    /**
     * @var InputFilter
     */
    private $inputFilter;

    public function __construct(Messages $messagesDao, Twig $twig, InputValidator $validator, InputFilter $filter = null)
    {
        $this->messagesDao = $messagesDao;
        $this->twig = $twig;
        $this->validator = $validator;
        //ez igy nem baj?
        $this->inputFilter = $filter ? $filter : new InputFilter();
    }

    public function getMessages(Request $request, Response $response, array $args)
    {
        $errors = $request->getQueryParam('errors');
        $messages = $this->messagesDao->listMessages();
        $this->twig->render($response, 'guestbook.html.twig', ['messages' => $messages, 'errors' => $errors]);
    }

    public function saveMessage(Request $request, Response $response, array $args)
    {
        $inputFilter = $this->inputFilter;
        $name = $inputFilter->filter($request->getParam('name'));
        $email = $inputFilter->filter($request->getParam('email'));
        $message = $inputFilter->filter($request->getParam('message'));
        $date = date('Y-m-d H:i:s');
        $errors = '';

        try {
            $this->validator->validate($name, $email, $message);
            $this->messagesDao->saveMessage($name, $email, $message, $date);
        } catch (\InvalidArgumentException $exception) {
            $errors = $exception->getMessage();
        }

        $redirectUrl = '/guestbook' . ($errors ? '?errors=' . $errors : '');
        return $response->withRedirect($redirectUrl);
    }
}