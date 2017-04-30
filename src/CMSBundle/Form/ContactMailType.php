<?php

namespace CMSBundle\Form;

use CMSBundle\Entity\ContactElement;
use CMSBundle\Entity\ContactMail;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactMailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('fromUser',EmailType::class,['label'=>'Your email :'])
            ->add('subject',TextType::class,['label'=>'Subject :'])
            ->add('body',CKEditorType::class,['label'=>'Content :', 'config' => array('toolbar' => 'basic')]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class'=>ContactMail::class]);
    }

    public function getBlockPrefix()
    {
        return 'cmsbundle_contact_element_type';
    }
}
