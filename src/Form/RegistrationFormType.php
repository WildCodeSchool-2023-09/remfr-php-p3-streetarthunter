<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class, [
                'label' => 'Nom: ',
                'attr' => ['placeholder' => 'Entrez votre nom']
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom: ',
                'attr' => ['placeholder' => 'Entrez votre prénom']
            ])
            ->add('username', TextType::class, [
                'label' => 'Pseudo: ',
                'attr' => ['placeholder' => 'Entrez votre pseudo']
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email: ',
                'attr' => ['placeholder' => 'Entrez votre adresse email']
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'Mot de passe: ', 'mapped' => false,
                    'attr' => ['autocomplete' => 'new-password', 'placeholder' => 'Entrez votre mot de passe']
                ],
                'second_options' => [
                    'label' => 'Confirmation du mot de passe: ', 'mapped' => false,
                    'attr' => ['autocomplete' => 'new-password', 'placeholder' => 'Entrez votre mot de passe'],
                ],
                'invalid_message' => 'Les mots de passe ne correspondent pas.'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
