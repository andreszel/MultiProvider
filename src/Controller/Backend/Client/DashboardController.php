<?php

namespace App\Controller\Backend\Client;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractController
{
    #[Route('/cl/dashboard', name: 'app_client_dashboard')]
    public function index(): Response
    {
        return $this->render('backend/client/dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
}
