<?php

namespace App\Controller\Front;

use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    #[Route('/movies', name: 'app_front_movie')]
    public function index(MovieRepository $movieRepository): Response
    {
        // get all movies
        $movies = $movieRepository->findAll();

        return $this->render('front/movie/index.html.twig', [
            'controller_name' => 'MovieController',
            'page_title' => 'Movies',
            'movies' => $movies,
        ]);
    }

    #[Route('/movie/{id}', name: 'app_front_movie_show')]
    public function show(MovieRepository $movieRepository, int $id): Response
    {
        // get movie by id
        $movie = $movieRepository->find($id);

        return $this->render('front/movie/show.html.twig', [
            'controller_name' => 'MovieController',
            'page_title' => 'Movie ' . $movie->getName(),
            'movie' => $movie,
        ]);
    }
}
