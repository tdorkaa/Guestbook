<?php

namespace Guestbook\Dao;

use Guestbook\PdoFactory;

class Guestbook
{
    /**
     * @var \PDO
     */
    private $PDO;

    public function __construct(\PDO $PDO)
    {
        $this->PDO = $PDO;
    }

    public function listMessages()
    {
        $statement = $this->PDO->query('SELECT name, email, message, created_at 
                                        FROM messages ORDER BY created_at DESC');
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

}