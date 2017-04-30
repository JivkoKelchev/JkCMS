<?php

namespace CMSBundle\Form;

use CMSBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditUserRolesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('isActive',ChoiceType::class,['label'=>'lock account', 'choices'=> [
                                                                                        'yes'=>0,
                                                                                        'no'=>1]])
            ->add('role',ChoiceType::class,['label'=>'change role', 'choices'=>[
                                                                        'admin'=>'ROLE_ADMIN',
                                                                        'editor'=>'ROLE_EDITOR',
                                                                        'user'=>'ROLE_USER'
            ]]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class'=>User::class]);
    }

    public function getBlockPrefix()
    {
        return 'cmsbundle_edit_user_roles';
    }
}
