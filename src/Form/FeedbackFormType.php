<?php

namespace App\Form;

use App\Form\Model\FeedbackFormModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FeedbackFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'required' => false
            ])
            ->add('email')
            ->add('message', TextareaType::class, [
                'attr' => [ 'rows' => 10 ]
            ])
            ->add('captcha', null, [
                'label' => 'Подтвердите что вы не БОТ',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FeedbackFormModel::class,
        ]);
    }
}
