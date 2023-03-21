<?php

// src/Components/CharacterCardComponent.php
namespace App\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;


#[AsTwigComponent('character_card')]
class CharacterCardComponent
{
  public string $name;
  public string $height;
  public string $mass;
  public string $gender;
  public string $picture = "https://picsum.photos/414/311";
  public string $editUrl = "#";
  public string $deleteUrl = "#";
}