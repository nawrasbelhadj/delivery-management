<?php

namespace App\Form\Alert;

use App\Entity\Alert;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddAlertFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('typeAlert', ChoiceType::class, options: [
                'placeholder' => 'Alert Type',
                'choices'  => [
                    'Obsolete received courier' => 'Alert_Sent',
                    'Obsolete sent courier' => 'Alert_Received',
                ],
            ] )

            ->add('save', SubmitType::class, ['label' => 'Save'])
            ->add('reset', ResetType::class, ['label' => 'Reset']);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Alert::class,
        ]);
    }


}
