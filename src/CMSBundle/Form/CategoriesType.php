<?php

namespace CMSBundle\Form;

use CMSBundle\Entity\PageCategories;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoriesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class,['label'=>'Add new category:']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class'=>PageCategories::class]);
    }

    public function getBlockPrefix()
    {
        return 'cmsbundle_categories_type';
    }
}
