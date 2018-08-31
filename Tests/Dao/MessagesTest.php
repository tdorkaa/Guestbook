<?php

namespace Tests\Dao;

use Guestbook\Dao\Messages;
use Guestbook\PdoFactory;
use PHPUnit\Framework\TestCase;

class MessagesTest extends TestCase
{
    private $PDO;
    private $messagesDao;

    public function setUp()
    {
        $pdoFactory = new PdoFactory();
        $this->PDO = $pdoFactory->getPDO();
        $this->PDO->query('TRUNCATE TABLE messages');
        $this->messagesDao = new Messages($this->PDO);
    }

    /**
     * @test
     */
    public function listMessages_MessageExists_ReturnsMessage()
    {
        $records = [
            [
                'name' => 'test name 1',
                'email' => 'test email 1',
                'message' => 'test message 1',
                'created_at' => '2018-08-29 10:00:00',
            ]
        ];
        $this->createRecords($records);
        $result = $this->messagesDao->listMessages();

        $this->assertEquals($records, $result);
    }

    /**
     * @test
     */
    public function listMessages_MultipleMessageExists_ReturnsMessagesInOrder()
    {
        $records = [
            [
                'name' => 'test name 1',
                'email' => 'test email 1',
                'message' => 'test message 1',
                'created_at' => '2018-08-29 10:00:00',
            ],
            [
                'name' => 'test name 2',
                'email' => 'test email 2',
                'message' => 'test message 2',
                'created_at' => '2018-08-30 10:00:00',
            ],
            [
                'name' => 'test name 3',
                'email' => 'test email 3',
                'message' => 'test message 3',
                'created_at' => '2018-08-21 10:00:00',
            ]
        ];
        $this->createRecords($records);
        $result = $this->messagesDao->listMessages();

        $this->assertEquals($records[1], $result[0]);
        $this->assertEquals($records[0], $result[1]);
        $this->assertEquals($records[2], $result[2]);
    }


    /**
     * @test
     */
    public function saveMessage_parametersAreGiven_saveMessagesToDb()
    {
        $name = 'test name';
        $email = 'test email';
        $message = 'test message';
        $date = '2018-08-21 10:00:00';

        $this->messagesDao->saveMessage($name, $email, $message, $date);
        //ez igy jo?
        $result = $this->messagesDao->listMessages();

        $this->assertEquals($name, $result[0]['name']);
        $this->assertEquals($email, $result[0]['email']);
        $this->assertEquals($message, $result[0]['message']);
        $this->assertEquals($date, $result[0]['created_at']);
    }

    private function createRecords($records)
    {
        $statement = $this->PDO->prepare('INSERT INTO messages (name, email, message, created_at) VALUES (:name, :email, :message, :created_at)');
        foreach ($records as $record) {
            $statement->execute($record);
        }
    }

}