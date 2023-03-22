<?php

// src/Components/CharacterCardComponent.php
namespace App\Components;

use App\Entity\Character;
use App\Repository\CharacterRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


#[AsTwigComponent('character_card')]
class CharacterCardComponent
{
  public Character $character;

  private UrlGeneratorInterface $router;

  public function __construct(UrlGeneratorInterface $router)
  {
    $this->router = $router;
  }

  public function getPicture(): string
  {
    $pictureName = '/uploads/characters/' . $this->character->getPicture();
    if (!$this->character->getPicture()) {
      $pictureName = 'http://via.placeholder.com/100x100';
    }
    return $pictureName;
  }

  public function getEditUrl(): string
  {
    return $this->router->generate('app_admin_character_edit', ['id' => $this->character->getId()]);
  }
}