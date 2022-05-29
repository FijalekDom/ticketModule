<?php

namespace App\Infrastructure\Repository;



use App\Domain\ValueObject\Ticket;
use App\Domain\ValueObject\User;
use App\Infrastructure\Entity\DoctrineUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class DoctrineTicketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DoctrineUser::class);
    }


    public function createAndGetInsertId(Ticket $ticket): int
    {
        $conn = $this->_em->getConnection();
        $sql = "INSERT INTO `ticket` (subject, email, message, attachment_name) 
                VALUES (:subject, :email, :message, :attachmentName)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue('subject', $ticket->getSubject());
        $stmt->bindValue('email', $ticket->getEmail());
        $stmt->bindValue('message', $ticket->getMessage());
        $stmt->bindValue('attachmentName', $ticket->getAttachmentName());
        $stmt->executeQuery();

        return $conn->lastInsertId();
    }
}