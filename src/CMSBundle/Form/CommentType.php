<?php

namespace CMSBundle\Form;

use CMSBundle\Entity\Comments;
use Doctrine\DBAL\Types\TextType;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('content',CKEditorType::class, ['required'=>true,
                                                    'label'=>'Add comment',
                                                    'config' => array('toolbar' => 'basic')
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class'=>Comments::class]);
    }

    public function getBlockPrefix()
    {
        return 'cmsbundle_comment_type';
    }
}
