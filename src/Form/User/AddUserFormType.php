<?php

namespace App\Form\User;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


class AddUserFormType extends AbstractType
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

            ->add('phoneNumber', TextType::class, array(
                'required' => false
            ))
            ->add('region', type: ChoiceType::class, options: [
                'placeholder' => 'Choose Your Governorate',
                'choices'  => [
                        'Ariana'     => 'Ariana',
                        'Beja'      => 'Beja',
                        'BenArous'  => 'Ben Arous',
                        'Bizerte'   => 'Bizerte',
                        'Babes'     => 'Gabes',
                        'Gafsa'     => 'Gafsa',
                        'Jendouba'  => 'Jendouba',
                        'Kairouan'  => 'Kairouan',
                        'Kasserine' => 'Kaserine',
                        'Kebili'    => 'Kebili',
                        'Kef'       => 'Kef',
                        'Mahdia'    => 'Mahdia',
                        'Manouba'   => 'Manouba',
                        'Medenine'  => 'Medenine',
                        'Monastir'  => 'Monastir',
                        'Nabeul'    => 'Nabeul',
                        'Sfax'      => 'sfax',
                        'SidiBouzid'=> 'Sidi Bouzid',
                        'Siliana'   => 'Siliana',
                        'Sousse'    => 'Sousse',
                        'Tataouine' => 'Tataouine',
                        'Tozeur'    => 'Tozeur',
                        'Tunis'     => 'Tunis',
                        'Zaghouan'  => 'Zaghouan',
                    ],

                ])
            ->add('password', RepeatedType::class, options: array(
                'type' => PasswordType::class,
                'required' => true,
                'constraints' => array(
                    new NotBlank(),
                    new Length(array('min' => 6)),
                ),
                'invalid_message' => 'The password fields must match.',
                'first_options'  => array('label' => 'label.password'),
                'second_options' => array('label' => 'label.passwordConfirmation'),
            ))

            ->add('adress', TextType::class, array(
                "mapped" => false,
            ))
            ->add('postCode', TextType::class, array(
                "mapped" => false,
            ))

            ->add('save', SubmitType::class, ['label' => 'Save'])
            ->add('reset', ResetType::class, ['label' => 'Reset']);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }


}
