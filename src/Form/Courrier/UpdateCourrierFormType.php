<?php

namespace App\Form\Courrier;

use App\Entity\Courrier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class UpdateCourrierFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('codeBarre', TextType::class)
            ->add('postDeparture', TextType::class)
            ->add('postArrival', TextType::class)
            ->add('typeCourrier', type: ChoiceType::class, options: [
                'placeholder' => 'Type',
                'choices'  => [
                    'Simple Courier' => 'Courrier_Simple',
                    'Large Courier' => 'Grand_Courrier',
                    'Multiple Couriers' => 'Courrier_Multiples'
                ],
            ])
            ->add('status', TextType::class)
            ->add('situation', TextType::class)

            ->add('save', SubmitType::class, ['label' => 'Save Changes'])
            ->add('reset', ResetType::class, ['label' => 'Reset']);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Courrier::class,
        ]);
    }
}