<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjController extends AbstractController
{
    #[Route("/proj", name: "app_proj")]
    public function index(): Response
    {
        return $this->render('proj/index.html.twig');
    }

    #[Route("/proj/about", name: "proj_about")]
    public function about(): Response
    {
        return $this->render('proj/about.html.twig');
    }
}
