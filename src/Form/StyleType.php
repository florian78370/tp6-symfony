<?php

namespace App\Form;

use App\Entity\Style;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class StyleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', TextType::class, [
            "attr"=> [
            'required'=>false,            
            'label'=>"nom du style",
            'Placeholder'=>"saisir le nom du style",                                                      
            ]])
            
            ->add('couleur', TextType::class, [
                'attr'=> [
                'required'=>false,            
                'label'=>"couleur associer au style",                                                     
                ]])              
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Style::class,
        ]);
    }
}
