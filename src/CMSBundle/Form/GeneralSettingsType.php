<?php

namespace CMSBundle\Form;

use CMSBundle\Entity\General;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GeneralSettingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('bgColor',TextType::class, ['required'=>false,
                                                  'label'=>'background color'])
            ->add('bgImageFile',FileType::class, ['label' => 'background image (Image file)',
                                                   'required'=>false])
            ->add('contactMail',EmailType::class,['label'=>'Contact mail'])
            ->add('bsTheme',ChoiceType::class, ['label'=> 'select bs theme',
                                                'choices'=>['Cerulean'=>'cerulean',
                                                            'Cosmo'=>'cosmo',
                                                            'Cyborg'=>'cyborg',
                                                            'Darkly'=>'darkly',
                                                            'Flatly'=>'flatly',
                                                            'Journal'=>'journal',
                                                            'Lumen'=>'lumen',
                                                            'Paper'=>'paper',
                                                            'Readable'=>'readable',
                                                            'Sandstone'=>'sandstone',
                                                            'Simplex'=>'simplex',
                                                            'Slate'=>'slate',
                                                            'Solar'=>'solar',
                                                            'Spacelab'=>'spacelab',
                                                            'Superhero'=>'superhero',
                                                            'United'=>'united',
                                                            'Yeti'=>'yeti']])
            ->add('guestMode',CheckboxType::class, ['label'=> 'guest mode','required'=> false]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class'=>General::class]);
    }

    public function getBlockPrefix()
    {
        return 'cmsbundle_general_settings';
    }
}
