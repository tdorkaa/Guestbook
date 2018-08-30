<?php

namespace Guestbook\Dao;

class Guestbook
{
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

    public function saveMessage($name, $email, $message, $date)
    {
        $statement = $this->PDO->prepare('INSERT INTO messages (name, email, message, created_at)
                                                    VALUES (:name, :email, :message, :created_at)');
        $statement->bindParam(':name', $name);
        $statement->bindParam(':email', $email);
        $statement->bindParam(':message', $message);
        $statement->bindParam(':created_at', $date);
        $statement->execute();
    }

}