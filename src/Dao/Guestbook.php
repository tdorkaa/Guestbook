<?php

namespace Guestbook\Dao;

use Guestbook\PdoFactory;

class Guestbook
{
    /**
     * @var \PDO
     */
    private $PDO;

    public function __construct()
    {
        $pdoFactory = new PdoFactory();
        $this->PDO = $pdoFactory->getPDO();
    }

    public function listMessages()
    {
        $statement = $this->PDO->query('SELECT name, email, message, created_at 
                                        FROM messages');
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

}