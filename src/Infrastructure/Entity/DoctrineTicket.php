<?php

namespace App\Infrastructure\Entity;


use App\Infrastructure\Repository\DoctrineTicketRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Table(name="ticket")
 *
 * @ORM\Entity(repositoryClass=DoctrineTicketRepository::class)
 */
class DoctrineTicket
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $subject;

    /**
     * @ORM\Column(type="string", length=180)
     */
    private string $email;

    /**
     * @ORM\Column(type="text")
     */
    private string $message;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private string $attachmentName;
}