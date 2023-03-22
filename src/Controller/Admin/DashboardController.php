<?php

namespace App\Controller\Admin;

use App\Repository\CharacterRepository;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/admin/dashboard', name: 'app_admin_dashboard')]
    public function index(CharacterRepository $characterRepository, MovieRepository $movieRepository): Response
    {
        $countMovies = $movieRepository->count([]);
        $countCharacters = $characterRepository->count([]);
        
        return $this->render('admin/dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'page_title' => 'Admin Dashboard',
            'count_movies' => $countMovies,
            'count_characters' => $countCharacters,
        ]);
    }
}
