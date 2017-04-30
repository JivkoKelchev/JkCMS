<?php

namespace CMSBundle\Form;

use CMSBundle\Entity\Pages;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PagePropertiesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile',FileType::class,['label'=>'Set page image','required'=>false])
            ->add('pageCategory',ChoiceType::class,['label'=>'Change category','required'=>false,'choices'=>$options['categories']])
            ->add('newTagName',TextType::class,['label'=>'Add Tag','required'=>false]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class'=>Pages::class,'categories'=>null]);
    }

    public function getBlockPrefix()
    {
        return 'cmsbundle_page_properties_type';
    }
}
