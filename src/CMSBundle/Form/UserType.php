<?php

namespace CMSBundle\Form;

use CMSBundle\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username',TextType::class,['label'=>'Username'])

                ->add('password',RepeatedType::class,['type' => PasswordType::class,
                                                        'first_options'=>['label'=>'Password'],
                                                        'second_options'=>['label'=>'Confirm password'],
                                                        'invalid_message' => 'The password fields must match.'])
                ->add('email',EmailType::class,['label'=>'Email']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class'=>User::class]);
    }

    public function getBlockPrefix()
    {
        return 'cmsbundle_user_type';
    }
}
