<?php

namespace CMSBundle\Form;

use CMSBundle\Entity\Pages;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title',TextType::class, ['label'=>'Title'])
            ->add('imageFile',FileType::class,['label'=>'Page image', 'required'=>false])
                ->add('pageCategory',ChoiceType::class,['label'=>'Select Category', 'required'=>false, 'choices'=>$options['categories']]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class'=>Pages::class,'categories'=>null]);
    }

    public function getBlockPrefix()
    {
        return 'cmsbundle_page_type';
    }
}
