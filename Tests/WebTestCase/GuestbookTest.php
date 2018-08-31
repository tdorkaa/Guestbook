<?php

namespace Tests\WebTestCase;

use Guestbook\Dao\Messages;
use Guestbook\PdoFactory;
use PHPUnit\Framework\TestCase;

class GuestbookTest extends TestCase
{
    use WebTestCase;

    /**
     * @test
     */
    public function calls_Guestbook_Returns200AndTemplateContents()
    {
        $pdoFactory = new PdoFactory();
        $PDO = $pdoFactory->getPDO();
        $PDO->query('TRUNCATE TABLE messages');
        $messagesDao = new Messages($PDO);
        $messagesDao->saveMessage('test name', 'test email', 'test message', '2018-08-29 10:00:00');

        $response = $this->runApp('GET', '/guestbook');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('test name', $response->getBody() . '');
        $this->assertContains('test message', $response->getBody() . '');
        $this->assertContains('2018-08-29 10:00:00', $response->getBody() . '');
    }
}