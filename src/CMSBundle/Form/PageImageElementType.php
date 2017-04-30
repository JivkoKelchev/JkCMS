<?php

namespace CMSBundle\Form;

use CMSBundle\Entity\PageImageElement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageImageElementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('height',NumberType::class,['label'=>'Image height :','required'=>false])
            ->add('width', NumberType::class, ['label'=>'Image width :','required'=>false]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class'=>PageImageElement::class]);
    }

    public function getBlockPrefix()
    {
        return 'cmsbundle_page_image_element_type';
    }
}
