<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ViewController extends AbstractController
{   
    #[Route('/', name: 'home')]
    #[Route('/index', name: 'index')]
    public function index(): Response
    {
        return $this->render('view/index.html.twig', [
            'controller_name' => 'ViewController',
        ]);
    }
}
