<?php

namespace App\Form\Bordereau;

use App\Entity\Bordereau;
use App\Entity\Courrier;
use App\Entity\Deliverer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BordereauFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('courriers', EntityType::class, [
                'required' => true,
                'mapped' => false,
                "multiple" => true,
                'class' => Courrier::class,
                'choice_label' => function(?Courrier $courrier) {
                    return $courrier != null ? $courrier->getCodeBarre() . " : " . $courrier->getTitle() : '';
                },
            ])
            ->add('deliverer', EntityType::class, [
                'required' => true,
                'class' => Deliverer::class,
                'choice_label' => function(?Deliverer $deliverer) {
                    return $deliverer != null ? $deliverer->getFirstName() : '';
                },
            ])
            ->add('save', SubmitType::class, ['label' => 'Save'])
            ->add('reset', ResetType::class, ['label' => 'Reset']);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bordereau::class,
        ]);
    }
}
