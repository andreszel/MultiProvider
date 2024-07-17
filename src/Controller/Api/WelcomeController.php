<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/v1', name: 'api_')]
class WelcomeController extends AbstractController
{
    #[Route('/welcome', name: 'welcome')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to API GYM SYSTEM!'
        ]);
    }

    #[Route('/security', name: 'security', methods: ['POST', 'GET'])]
    public function security(): JsonResponse
    {
        return $this->json([
            'message' => 'security url!',
            'date' => $this->getCuurentDateAsString()
        ]);
    }

    private function getCuurentDateAsString()
    {
        $currentDate = new \DateTime('now', new \DateTimeZone('Europe/Warsaw'));
        return $currentDate->format("Y-m-d H:i:s");
    }
}
