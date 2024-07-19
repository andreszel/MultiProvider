<?php

namespace App\Controller\Frontend\Owner;

use App\Service\CurrentDate;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_owner_home', host: "gadmin.test")]
    public function index(): Response
    {
        $currentDate = new CurrentDate();
        return $this->render('frontend/owner/home/index.html.twig', [
            'date' => $currentDate()
        ]);
    }
}
