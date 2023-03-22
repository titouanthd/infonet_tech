<?php

namespace App\Controller\Front;

use App\Entity\Character;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CharacterController extends AbstractController
{
    #[Route('/character/{id}', name: 'app_front_character_show')]
    public function show(Character $character): Response
    {
        return $this->render('front/character/show.html.twig', [
            'controller_name' => 'CharacterController',
            'page_title' => 'Character details',
            'character' => $character,
        ]);
    }
}
