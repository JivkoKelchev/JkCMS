<?php

namespace CMSBundle\Form;


use CMSBundle\Entity\PageLinkElement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PageLinkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('slug',ChoiceType::class,['choices'=>$options['pages'],'label'=>'Select Page']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class'=>PageLinkElement::class, 'pages'=>null]);
    }

    public function getBlockPrefix()
    {
        return 'cmsbundle_page_link_type';
    }
}
