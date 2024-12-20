<?php

namespace App\Form\Agent;

use App\Entity\Agent;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class UpdateAgentProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cin', TextType::class )
            ->add('email', TextType::class)
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('region', type: TextType::class)
            ->add('userRole', type: ChoiceType::class, options: [
                'placeholder' => 'User Role',

                'choices'  => [
                    'Admin Agent' => 'ROLE_AGENTADMIN',
                    'Normal Agent' => 'ROLE_AGENT',

                ],
                "mapped" => false,

            ])
            ->add('save', SubmitType::class, ['label' => 'Save Changes'])
            ->add('reset', ResetType::class, ['label' => 'Reset']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Agent::class,
        ]);
    }


}
