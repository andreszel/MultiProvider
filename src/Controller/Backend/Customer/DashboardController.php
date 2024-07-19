<?php

namespace App\Controller\Backend\Customer;

use App\Service\CurrentDate;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractController
{
    #[Route('/cu/dashboard', name: 'app_customer_dashboard')]
    public function index(): Response
    {
        $currentDate = new CurrentDate();
        return $this->render('backend/customer/dashboard/index.html.twig', [
            'date' => $currentDate()
        ]);
    }
}
