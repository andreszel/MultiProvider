<?php

namespace App\Controller\Frontend\Customer;

use App\Service\CurrentDate;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_customer_home', host: "gcustomer.test")]
    public function index(): Response
    {
        $currentDate = new CurrentDate();
        return $this->render('frontend/customer/home/index.html.twig', [
            'date' => $currentDate()
        ]);
    }
}
