<?php

namespace CMSBundle\Form;

use CMSBundle\Entity\Navbar;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NavbarType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('brand',TextType::class,['label'=>'Brand : ','required'=>false])
                ->add('logoFile',FileType::class,['label'=>'Logo image : ','required'=>false])
                ->add('categories',ChoiceType::class,['label'=>'Add page categories : ','required'=>false,
                                                        'placeholder' => 'none',
                                                        'choices'=>['single links'=>'links',
                                                                    'drop down list'=>'list']])
                ->add('sl',ChoiceType::class, ['label'=>'Add single link to :', 'required'=> false,
                                                        'placeholder' => 'none',
                                                        'choices'=> $options['pages']])
                ->add('searchByTags',CheckboxType::class, ['label'=> 'Add search by tags', 'required'=>false])
                ->add('logInOut', CheckboxType::class, ['label'=> 'Add Log In/Out links', 'required'=>false]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class'=>Navbar::class, 'pages'=>null]);
    }

    public function getBlockPrefix()
    {
        return 'cmsbundle_navbar_type';
    }
}
