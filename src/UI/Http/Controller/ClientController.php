<?php

namespace App\UI\Http\Controller;

use App\Application\Command\SendTickedAddedEmail;
use App\Application\Exception\InvalidEmailException;
use App\Application\Service\FileUploader;
use App\Domain\Constant\TicketSubject;
use App\Domain\ValueObject\Ticket;
use App\Infrastructure\Repository\DoctrineTicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/client')]
class ClientController extends AbstractController
{
    #[Route('/form', name: 'client_form')]
    public function form(): Response
    {
        $subjects = TicketSubject::getTicketSubjectsWithNames();

        return $this->render('client/form.html.twig',[
            'subjects' => $subjects
        ]);
    }

    #[Route('/add-ticket', name: 'add_ticket', methods: ['POST'])]
    public function add(Request $request,
                        FileUploader $fileUploader,
                        DoctrineTicketRepository $doctrineTicketRepository,
                        MessageBusInterface $messageBus
    ): Response {
        try {
            $subject = $request->get('subject');
            $email = $request->get('email');
            $message = $request->get('message');
            $file = $request->files->get('attachment');
            $filename = $file ? $file->getClientOriginalName() : null;
            $ticket = new Ticket($subject, $email, $message, $filename);
            $id = $doctrineTicketRepository->createAndGetInsertId($ticket);

            if($file) {
                $fileUploader->upload($file, $id);
            }

            $messageBus->dispatch(new SendTickedAddedEmail($ticket));

            return $this->render('client/success.html.twig');
        } catch (InvalidEmailException $e) {
            return $this->render('client/error.html.twig', [
                'errorMessage' => $e->getMessage()
            ]);
        }
    }
}