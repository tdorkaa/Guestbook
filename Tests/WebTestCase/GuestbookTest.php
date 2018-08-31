<?php

namespace Tests\WebTestCase;

use Guestbook\Dao\Messages;
use Guestbook\PdoFactory;
use PHPUnit\Framework\TestCase;

class GuestbookTest extends TestCase
{
    use WebTestCase;

    /**
     * @var Messages
     */
    private $messagesDao;

    protected function setUp()
    {
        $pdoFactory = new PdoFactory();
        $PDO = $pdoFactory->getPDO();
        $PDO->query('TRUNCATE TABLE messages');
        $this->messagesDao = new Messages($PDO);
    }

    /**
     * @test
     */
    public function calls_Guestbook_Returns200AndTemplateContents()
    {
        $name = 'test name';
        $email = 'test email';
        $message = 'test message';
        $date = '2018-08-29 10:00:00';
        $this->messagesDao->saveMessage($name, $email, $message, $date);

        $response = $this->runApp('GET', '/guestbook');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains($name, $response->getBody() . '');
        $this->assertContains($message, $response->getBody() . '');
        $this->assertContains($date, $response->getBody() . '');
    }

    /**
     * @test
     */
    public function calls_GuestbookWithErrorsParameters_Returns200AndTemplateContentsWithErrorMessages()
    {
        $errorMessage = 'wrong email';
        $response = $this->runApp('GET', '/guestbook?errors=' . $errorMessage);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains($errorMessage, $response->getBody() . '');
    }

    /**
     * @test
     */
    public function calls_SaveGuestbook_Returns301WithRedirect()
    {
        $data = [
            'name' => 'Test name',
            'email' => 'test@test.test',
            'message' => 'Test message'
        ];
        $response = $this->runApp('POST', '/guestbook/save', $data);
        $result = $this->messagesDao->listMessages();

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertEquals($data['name'], $result[0]['name']);
        $this->assertEquals($data['email'], $result[0]['email']);
        $this->assertEquals($data['message'], $result[0]['message']);
    }

    /**
     * @test
     */
    public function calls_SaveGuestbookWithEmptyData_ReturnsWithErrorMessage()
    {
        $data = [];
        $response = $this->runApp('POST', '/guestbook/save', $data);
        $result = $this->messagesDao->listMessages();

        $this->assertEquals(302, $response->getStatusCode());
        $this->assertContains('?errors=Name required,Email required,Message required', $response->getHeaderLine('Location'));
        $this->assertEquals(0, count($result));
    }
}