<?php

namespace App\Application\CommandHandler;

use App\Application\Command\SendTickedAddedEmail;
use App\Infrastructure\Query\GetAdminEmailQuery;
use App\Infrastructure\Repository\DoctrineUserRepository;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Mime\Email;

class SendTickedAddedEmailHandler implements MessageHandlerInterface
{
    private GetAdminEmailQuery $getAdminEmailQuery;
    private MailerInterface $mailer;

    public function __construct(GetAdminEmailQuery $getAdminEmailQuery, MailerInterface $mailer)
    {
        $this->getAdminEmailQuery = $getAdminEmailQuery;
        $this->mailer = $mailer;
    }

    public function __invoke(SendTickedAddedEmail $sendTickedAddedEmail): void
    {
        $ticket = $sendTickedAddedEmail->getTicket();
        $message = "Użytkownik " . $ticket->getEmail() . " dodał zgłosznie o temacie " . $ticket->getSubject() . '.';
        $email = $this->getAdminEmailQuery->getResult();

        $email = (new Email())
            ->from($_SERVER['EMAIL_FROM'])
            ->to($email)
            ->subject('Nowe zgłoszenie')
            ->html('<p>' . $message . '</p>');


            $this->mailer->send($email);

    }

}