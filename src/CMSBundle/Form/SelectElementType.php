<?php

namespace CMSBundle\Form;

use CMSBundle\Entity\ElementType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SelectElementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('Type', ChoiceType::class, ['label'=> 'Select Element Type',
                                                    'choices'=>['Text'=>'TextElement',
                                                                'Page image'=>'PageImageElement',
                                                                'Page link button'=>'PageLinkElement',
                                                                'Pages list'=>'PageListElement',
                                                                'Comments'=>'CommentsElement',
                                                                'Contact form'=>'ContactElement',
                                                                'Google maps'=>'MapElement'

                                                                ]]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class'=> ElementType::class ]);
    }

    public function getBlockPrefix()
    {
        return 'cmsbundle_select_element';
    }
}
