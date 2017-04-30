<?php

namespace CMSBundle\Form;

use CMSBundle\Entity\MapElement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MapElementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('latitude',TextType::class,['label'=>'Latitude :'])
            ->add('longitude',TextType::class,['label'=>'Longitude']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class'=>MapElement::class]);
    }

    public function getBlockPrefix()
    {
        return 'cmsbundle_map_element_type';
    }
}
