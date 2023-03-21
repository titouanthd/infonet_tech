<?php

namespace App\Form;

use App\Entity\Character;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CharacterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('mass')
            ->add('height')
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    "male" => 'male',
                    "female" => 'female',
                    "hermaphrodite" => 'hermaphrodite',
                    "n/a" => 'n/a',
                ],
                'autocomplete' => true,
            ])
            ->add('picture', FileType::class, [
                'mapped' => false,
                'required' => false,
            ])
            // ->add('movies', Choice)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Character::class,
        ]);
    }
}
