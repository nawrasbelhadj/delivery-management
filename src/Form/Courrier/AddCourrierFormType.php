<?php

namespace App\Form\Courrier;

use App\Entity\Courrier;
use App\Entity\Deliverer;
use App\Entity\Post;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;



class AddCourrierFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('codeBarre', TextType::class)



            ->add('postArrival', EntityType::class, [
                'required' => true,
                'class' => Post::class,
                'choice_label' => function(?Post $post) {
                    return $post != null ? $post->getNamePost() : '';
                },
            ])



            ->add('typeCourrier', type: ChoiceType::class, options: [
                'placeholder' => 'Type',
                'choices'  => [
                    'Simple Courier' => 'Courrier_Simple',
                    'Large Courier' => 'Grand_Courrier',
                    'Multiple Couriers' => 'Courrier_Multiples'
                ],
            ])

            ->add('title', TextType::class )

            ->add('message', TextareaType::class )


            ->add('save', SubmitType::class, ['label' => 'Save'])
            ->add('reset', ResetType::class, ['label' => 'Reset']);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Courrier::class,
        ]);
    }
}
