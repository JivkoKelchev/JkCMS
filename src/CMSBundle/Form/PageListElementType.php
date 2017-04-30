<?php

namespace CMSBundle\Form;

use CMSBundle\Entity\PageListElement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageListElementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('pageLimit',NumberType::class,['required'=>false])
            ->add('catFilter',ChoiceType::class,['choices'=>$options['categories'] ,'label'=>'Select Category', 'required'=>false])
        ->add('type', ChoiceType::class,['choices'=>['list'=>'list','carousel'=>'carousel'],'label'=>'Select type']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class'=>PageListElement::class, 'categories'=>null]);
    }

    public function getBlockPrefix()
    {
        return 'cmsbundle_page_list_element_type';
    }
}
