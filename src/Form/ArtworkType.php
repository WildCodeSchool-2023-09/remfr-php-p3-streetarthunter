<?php

namespace App\Form;

use App\Entity\Artwork;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class ArtworkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('longitude', NumberType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Longitude']
            ])
            ->add('latitude', NumberType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Latitude']
            ])
            ->add('city', TextType::class, [
                'label' => false,
                'attr' => ['placeholder' => 'Ville']
            ])
            ->add('image', ImageType::class, [
                'label' => false
            ])
            ->add('point', PointType::class, [
                'label' => false
            ])
            ->add('artist', ArtistType::class, [
                'label' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Artwork::class,
        ]);
    }
}
