<?php

namespace App\Controller\Front;

use App\Repository\CharacterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_front_home')]
    public function index(CharacterRepository $characterRepository): Response
    {
        // get all characters
        $characters = $characterRepository->findAll();

        return $this->render('front/home/index.html.twig', [
            'controller_name' => 'HomeController',
            'page_title' => 'Home',
            'characters' => $characters,
        ]);
    }
}
