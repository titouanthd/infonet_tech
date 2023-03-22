<?php

// src/Components/MovieCardComponent.php
namespace App\Components;

use App\Entity\Movie;
use App\Repository\MovieRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


#[AsTwigComponent('movie_card')]
class MovieCardComponent
{
  public Movie $movie;

  private UrlGeneratorInterface $router;

  public function __construct(UrlGeneratorInterface $router)
  {
    $this->router = $router;
  }

  public function getEditUrl(): string
  {
    return $this->router->generate('app_admin_movie_edit', ['id' => $this->movie->getId()]);
  }
}