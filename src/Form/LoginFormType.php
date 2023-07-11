<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class LoginFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('_username', EmailType::class, ["property_path"=> 'email','label' => "Email",'attr' => [
                'name' => '_username', // Ajoutez cette ligne pour définir l'attribut name à "_username"
            ], 'constraints' => [
                new NotBlank([
                    'message' => 'L\'email ne peut pas être vide.',
                ])
            ]])
            ->add('_password', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                "property_path"=> 'password',
                'mapped' => false,
                'label' => "Mot de passe",
                'attr' => [  'name' => '_password','autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le mot de passe ne peut pas être vide.',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Le mot de passe doit contenir au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ]);
    }

    public function getBlockPrefix()
    {
        return ''; // Retourne une chaîne vide pour supprimer le préfixe par défaut
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
