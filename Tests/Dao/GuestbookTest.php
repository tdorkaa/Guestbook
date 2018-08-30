<?php

namespace Tests\Dao;

use Guestbook\Dao\Guestbook;
use Guestbook\PdoFactory;
use PHPUnit\Framework\TestCase;

class GuestbookTest extends TestCase
{
    private $PDO;

    public function setUp()
    {
        $pdoFactory = new PdoFactory();
        $this->PDO = $pdoFactory->getPDO();
    }

    /**
     * @test
     */
    public function listMessages_MessageExists_ReturnsMessage()
    {
        $this->PDO->query('TRUNCATE TABLE messages');
        $records = [
            [
                'name' => 'test name 1',
                'email' => 'test email 1',
                'message' => 'test message 1',
                'created_at' => '2018-08-29 10:00:00',
            ]
        ];
        $this->createRecords($records);

        $guestBookDao = new GuestBook($this->PDO);
        $result = $guestBookDao->listMessages();

        $this->assertEquals($records, $result);
    }

    private function createRecords($records)
    {
        $statement = $this->PDO->prepare('INSERT INTO messages (name, email, message, created_at) VALUES (:name, :email, :message, :created_at)');
        foreach ($records as $record) {
            $statement->execute($record);
        }
    }

}