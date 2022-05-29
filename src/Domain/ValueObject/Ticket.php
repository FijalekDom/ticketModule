<?php

namespace App\Domain\ValueObject;

use App\Application\Exception\InvalidEmailException;

class Ticket
{
    private string $subject;
    private string $email;
    private string $message;
    private ?string $attachmentName;

    public function __construct(
        string $subject,
        string $email,
        string $message,
        ?string $attachmentName
    ) {
        if (!$this->isValidEmail($email)) {
            throw new InvalidEmailException(sprintf("Invalid email: %s", $email));
        }

        $this->subject = $subject;
        $this->email = $email;
        $this->message = $message;
        $this->attachmentName = $attachmentName;
    }

    private function isValidEmail(string $email): bool
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getAttachmentName(): ?string
    {
        return $this->attachmentName;
    }


}