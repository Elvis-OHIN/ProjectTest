<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
require __DIR__ . "/../Repository/ContactRepository.php";
require __DIR__ . "/../Models/Contact.php";

final class ContactRepositoryTest extends TestCase
{
    private $repository;

    private $pdo;

    protected function setUp(): void
    {
        $pathToDb = __DIR__ . '/../database.sqlite';
        $this->pdo = new PDO("sqlite:$pathToDb");
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->query("CREATE TABLE IF NOT EXISTS contact (
            id            INTEGER         PRIMARY KEY AUTOINCREMENT,
            firstname         VARCHAR( 50 ),
            lastname       VARCHAR( 50 ),
            birthday  DATETIME
        );");
        $this->repository = new ContactRepository($pdo);
        

    }

    public function testCanAddContact(): void
    {
        $contact = new Contact('Elvis', 'OHIN', '2002-03-29');
        $this->repository->add($contact);
        $this->assertSame($contact->getId(), $this->repository->findById($contact->getId())->getId());
    }
    public function testCanAddContactException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $contact = new Contact('', '', '');
        $this->repository->add($contact);
    }

    public function testCanFindContactById(): void
    {
        $contact = new Contact('Elvis', 'OHIN', '2002-03-29');
        $this->repository->add($contact);
        $this->assertSame($contact->getId(), $this->repository->findById($contact->getId())->getId());
    }


    public function delete(Contact $contact): void
    {
        $existingContact = $this->repository->findById($contact->getId());
        if(!$existingContact) {
            throw new InvalidArgumentException("Contact with ID {$contact->getId()} does not exist.");
        }

        $stmt = $this->pdo->prepare('DELETE FROM contact WHERE id = ?');
        $stmt->execute([$contact->getId()]);
    }
}
