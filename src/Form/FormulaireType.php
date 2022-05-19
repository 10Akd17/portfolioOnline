<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class FormulaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class,['attr'=>['placeholder'=> 'Nom']])
            ->add('prenom', TextType::class,['attr'=>['placeholder'=> 'Prenom'] ])
            ->add('email', EmailType::class,['attr'=>['placeholder' => 'Email']])
            ->add('message', TextareaType::class,['attr'=>['placeholder'=> 'Message']])
            ->add('submit', SubmitType::class,['attr'=>['placeholder'=>'Submit']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
