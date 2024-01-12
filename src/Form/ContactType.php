<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class, [
                'attr' => ['placeholder' => 'Nom'],
                'label' => false
            ])
            ->add('firstname', TextType::class, [
                'attr' => ['placeholder' => 'Prenom'],
                'label' => false
            ])
            ->add('mail', EmailType::class, [
                'attr' => ['placeholder' => 'email@email.fr'],
                'label' => false
            ])
            ->add('message', TextareaType::class, [
                'attr' => ['placeholder' => 'Veuillez saisir le motif de votre message'],
                'label' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
