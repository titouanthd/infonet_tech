<?php

// src/Components/AlertComponent.php
namespace App\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;


#[AsTwigComponent('alert')]
class AlertComponent
{
  public string $type = 'success';
  public string $message;
}