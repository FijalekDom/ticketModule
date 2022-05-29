<?php

namespace App\Application\Command;

use App\Domain\ValueObject\Ticket;

class SendTickedAddedEmail
{
    private Ticket $ticket;

    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function getTicket(): Ticket
    {
        return $this->ticket;
    }
}