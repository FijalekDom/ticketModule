<?php

namespace App\UI\Http\Controller;

use App\Infrastructure\Query\GetTicketsQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/admin')]
class AdminController extends AbstractController
{


    #[Route('/list', name: 'admin_list')]
    public function list(GetTicketsQuery $getTicketsQuery): Response
    {
        $tickets = $getTicketsQuery->getResult();

        return $this->render('admin/list.html.twig', [
                'tickets' => $tickets
            ]);
    }
}