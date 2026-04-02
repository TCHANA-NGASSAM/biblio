<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function home(): Response
    {
        if (null === $this->getUser()) {
            return new Response('Bienvenue sur BiblioConnect. Connecte-toi pour acceder a ton espace.');
        }

        return $this->redirectToRoute('app_post_login_redirect');
    }

    #[Route('/post-login', name: 'app_post_login_redirect')]
    public function postLoginRedirect(): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_admin_dashboard');
        }

        if ($this->isGranted('ROLE_LIBRARIAN')) {
            return $this->redirectToRoute('app_librarian_dashboard');
        }

        return $this->redirectToRoute('app_user_dashboard');
    }

    #[Route('/account', name: 'app_user_dashboard')]
    public function userDashboard(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        return new Response('Espace usager BiblioConnect');
    }

    #[Route('/librarian', name: 'app_librarian_dashboard')]
    public function librarianDashboard(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_LIBRARIAN');

        return new Response('Espace bibliothecaire BiblioConnect');
    }

    #[Route('/admin', name: 'app_admin_dashboard')]
    public function adminDashboard(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return new Response('Espace admin BiblioConnect');
    }
}
