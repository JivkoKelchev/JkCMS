<?php

namespace CMSBundle\Form;

use CMSBundle\Entity\TextElement;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TextElementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('content',CKEditorType::class,['label' => false]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class'=>TextElement::class]);
    }

    public function getBlockPrefix()
    {
        return 'cmsbundle_text_element_type';
    }
}
