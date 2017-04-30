<?php

namespace CMSBundle\Form;

use CMSBundle\Entity\Styles;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StyleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('bgColor',TextType::class,['label'=>'bg color', 'required'=>false])
//                ->add('bgImage',FileType::class, ['label'=>'bg image', 'required'=>false])
//                ->add('transparency', NumberType::class, ['label'=>'transparency', 'required'=>false])
                ->add('borderColor',TextType::class, ['label'=>'borders color','required'=>false])
                ->add('topBorder', NumberType::class, ['label'=>'top [px]', 'required'=>false])
                ->add('leftBorder', NumberType::class, ['label'=>'left [px]', 'required'=>false])
                ->add('rightBorder', NumberType::class, ['label'=>'right [px]', 'required'=>false])
                ->add('bottomBorder', NumberType::class, ['label'=>'bottom [px]', 'required'=>false])
                ->add('roundBorder', NumberType::class, ['label'=>'create rounded corners [px]', 'required'=>false])
                ->add('topMargin', NumberType::class, ['label'=>'top [%]', 'required'=>false])
                ->add('leftMargin', NumberType::class, ['label'=>'left [%]', 'required'=>false])
                ->add('rightMargin', NumberType::class, ['label'=>'right [%]', 'required'=>false])
                ->add('bottomMargin', NumberType::class, ['label'=>'bottom [%]', 'required'=>false])
                ->add('topPadding', NumberType::class, ['label'=>'top [%]', 'required'=>false])
                ->add('leftPadding', NumberType::class, ['label'=>'left [%]', 'required'=>false])
                ->add('rightPadding', NumberType::class, ['label'=>'right [%]', 'required'=>false])
                ->add('bottomPadding', NumberType::class, ['label'=>'bottom [%]', 'required'=>false])
                ->add('maxWidth', NumberType::class, ['label'=>'max width [%]', 'required'=>false])
                ->add('minWidth',NumberType::class, ['label'=>'min width [%]','required'=>false])
                ->add('maxHeight', NumberType::class, ['label'=>'max height [%]', 'required'=>false])
                ->add('minHeight', NumberType::class, ['label'=>'min height [%]', 'required'=>false]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class'=>Styles::class]);
    }

    public function getBlockPrefix()
    {
        return 'cmsbundle_style_type';
    }
}
