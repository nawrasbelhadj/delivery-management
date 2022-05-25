<?php

namespace App\Form\User;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class UpdateUserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cin', TextType::class )
            ->add('email', TextType::class)
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)

            ->add('userRole', type: ChoiceType::class, options: [
                'placeholder' => 'User Role',
                'choices'  => [
                    'Post Agent' => 'ROLE_AGENT',
                    'Deliverer' => 'ROLE_USER',
                    'Administrator' => 'ROLE_ADMIN'
                ],
                "mapped" => false,

            ])


            ->add('region', type: TextType::class)


            ->add('save', SubmitType::class, ['label' => 'Save Changes'])
            ->add('reset', ResetType::class, ['label' => 'Reset']);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }


}
