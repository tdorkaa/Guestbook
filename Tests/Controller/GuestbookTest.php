<?php

namespace Tests\Controller;


use Guestbook\Dao\Messages;
use PHPUnit\Framework\TestCase;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;

class GuestbookTest extends TestCase
{
    /**
     * @test
     */
    public function getGuestbook_GivenMessagesInDB_callsMessagesDaoAndRenderContent()
    {
        $messages = [['name' => 'Test name']];
        $mockMessagesDao = $this->createMock(Messages::class);
        $mockMessagesDao->expects($this->once())
            ->method('listMessages')
            ->willReturn($messages);

        $mockResponse = $this->createMock(Response::class);
        $mockRequest = $this->createMock(Request::class);

        $mockTwig = $this->createMock(Twig::class);
        $mockTwig->expects($this->once())
            ->method('render')
            ->with($mockResponse, 'guestbook.html.twig', ['messages' => $messages]);

        $guestbook = new \Guestbook\Controller\Guestbook($mockMessagesDao, $mockTwig);
        $guestbook->getMessages($mockRequest, $mockResponse, []);
    }

}