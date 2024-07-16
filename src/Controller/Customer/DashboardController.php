<?php

namespace App\Controller\Customer;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractController
{
    #[Route('/customer/dashboard', name: 'app_customer_dashboard')]
    public function index(): Response
    {
        return $this->render('customer/dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
}
