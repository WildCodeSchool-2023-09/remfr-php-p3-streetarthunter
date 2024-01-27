<?php

namespace App\Form;

use App\Entity\Artist;
use App\Entity\Artwork;
use App\Entity\Image;
use App\Entity\Point;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArtworkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('longitude')
            ->add('latitude')
            ->add('city')
            ->add('user', EntityType::class, [
                'class' => User::class,
        'choice_label' => 'id',
        'multiple' => true,
            ])
            ->add('point', EntityType::class, [
                'class' => Point::class,
        'choice_label' => 'id',
            ])
            ->add('image', EntityType::class, [
                'class' => Image::class,
        'choice_label' => 'id',
            ])
            ->add('artist', EntityType::class, [
                'class' => Artist::class,
        'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Artwork::class,
        ]);
    }
}
