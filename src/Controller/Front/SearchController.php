<?php

namespace App\Controller\Front;

use App\Repository\CharacterRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_front_search')]
    public function index(Request $request, CharacterRepository $characterRepository): Response
    {
        $searchTerm = $request->query->get('q');

        if (!$searchTerm) {
            // set search term to empty string
            $searchTerm = '';
        }

        $characters = $characterRepository->searchByName($searchTerm);

        return $this->render('front/search/index.html.twig', [
            'controller_name' => 'SearchController',
            'page_title' => 'Search',
            'characters' => $characters,
            'searchTerm' => $searchTerm,
        ]);
    }
}
