<?php

namespace Tests\Controller;


use Guestbook\Controller\Guestbook;
use Guestbook\Dao\Messages;
use PHPUnit\Framework\TestCase;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;

class GuestbookTest extends TestCase
{

    private $mockMessagesDao;

    private $mockResponse;
    private $mockRequest;
    private $mockTwig;
    private $guestbook;

    protected function setUp()
    {
        $this->mockMessagesDao = $this->createMock(Messages::class);
        $this->mockResponse = $this->createMock(Response::class);
        $this->mockRequest = $this->createMock(Request::class);
        $this->mockTwig = $this->createMock(Twig::class);
        $this->guestbook = new Guestbook($this->mockMessagesDao, $this->mockTwig);
    }

    /**
     * @test
     */
    public function getGuestbook_GivenMessagesInDB_callsMessagesDaoAndRenderContent()
    {
        $messages = [['name' => 'Test name']];

        $this->mockMessagesDao->expects($this->once())
            ->method('listMessages')
            ->willReturn($messages);


        $this->mockTwig->expects($this->once())
            ->method('render')
            ->with($this->mockResponse, 'guestbook.html.twig', ['messages' => $messages]);

        $this->guestbook->getMessages($this->mockRequest, $this->mockResponse, []);
    }

    /**
     * @test
     */
    public function saveMessage_SaveMessageToDB_callsDaoSaveMessage()
    {

        $this->mockMessagesDao
            ->expects($this->once())
            ->method('saveMessage')
            ->with('Test name', 'test email', 'Test message');

        $this->mockRequest
            ->expects($this->exactly(3))
            ->method('getParam')
            ->withConsecutive(['name'], ['email'], ['message'])
            ->willReturnOnConsecutiveCalls('Test name', 'test email', 'Test message');

        $this->mockResponse
            ->expects($this->once())
            ->method('withRedirect')
            ->with('/guestbook');

        $this->guestbook->saveMessage($this->mockRequest, $this->mockResponse, []);
    }

}