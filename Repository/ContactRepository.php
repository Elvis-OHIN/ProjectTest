<?php
declare(strict_types=1);

class ContactRepository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function add(Contact $contact): void
    {

        if($contact->getFirstname() == null) {
            throw new InvalidArgumentException("Invalid firstname.");
        }


        if($contact->getLastname()  == null) {
            throw new InvalidArgumentException("Invalid lastname.");
        }



        $stmt = $this->pdo->prepare('INSERT INTO contact (firstname, lastname, birthday) VALUES (?, ?, ?)');
        $stmt->execute([$contact->getFirstname(), $contact->getLastname(), $contact->getBirsthday()]);
        $id = $this->pdo->lastInsertId();
        $contact->setId((int)$id);

    }


    public function findById($id): ?Contact
    {
        $stmt = $this->pdo->prepare('SELECT * FROM contact WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }

        $contact = new Contact($row['firstname'], $row['lastname'], $row['birthday']);
        $contact->setId((int)$row['id']);
        return $contact;
    }


    public function findAll(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM contact');
        $contacts = [];
        while ($row = $stmt->fetch()) {
            $contacts[] = new Contact($row['firstname'], $row['lastname'], $row['birthday']);
        }

        return $contacts;
    }

    public function delete(Contact $contact): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM contact WHERE id = ?');
        $stmt->execute([$contact->getId()]);
    }
}
