<?php

namespace App\Form;

use App\Entity\Artwork;
use App\Entity\Image;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
                $builder
                ->add('artwork', EntityType::class, [
                'class' => Artwork::class,
                'choice_label' => 'id',
                ])
                ->add('file', VichFileType::class, [
                'required' => false,
                'allow_delete' => true,
                'download_uri' => true,
                'attr' => ['capture' => 'environment','class' => 'button-camera' ]
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }
}