<?php

namespace App\Form\Courrier;

use App\Entity\Courrier;
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


class UpdateCourrierFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('codeBarre', TextType::class,[
                'disabled' => true,
            ] )
            ->add('postDeparture', EntityType::class, [
                'required' => true,
                'disabled' => true,
                'class' => Post::class,
                'choice_label' => function(?Post $post) {
                    return $post != null ? $post->getNamePost() : '';
                },
            ])
            ->add('postArrival', EntityType::class, [
                'required' => true,
                'class' => Post::class,
                'choice_label' => function(?Post $post) {
                    return $post != null ? $post->getNamePost() : '';
                },
            ])
            ->add('typeCourrier', type: ChoiceType::class, options: [

                'disabled' => true,

            ])

            ->add('title', TextType::class,[
                'disabled' => true,
            ] )

            ->add('message', TextareaType::class ,[
                'disabled' => true,
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
