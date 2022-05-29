<?php

namespace App\UI\Http\Controller;

use App\Domain\Constant\UserRole;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AuthController extends AbstractController
{
    #[Route('/', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $user = $this->getUser();
        if($user) {
            return $this->redirect('/check-user-privileges');
        }
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('auth/login.html.twig', [
            'controller_name' => 'LoginController',
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    #[Route('/logout', name: 'logout')]
    public function logout(): void
    {
        throw new \Exception('Logout error');
    }

    #[Route('/check-user-privileges', name: 'check_user_privileges')]
    public function checkUserPrivileges(): Response
    {
        $user = $this->getUser();
        if($user->getRoles()[0] == UserRole::ROLE_ADMIN) {
            return $this->redirect('/admin/list');
        } else {
            return $this->redirect('/client/form');
        }
    }
}