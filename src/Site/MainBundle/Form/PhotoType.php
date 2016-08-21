<?php

namespace Site\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PhotoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('created', 'datetime', array(
            //     'required' => true,
            //     'label' => 'backend.photo.created'
            // ))
            ->add('title', 'text', array(
                'required' => false,
                'label' => 'backend.photo.title'
            ))
            // ->add('metaTitle', 'text', array(
            //     'required' => false,
            //     'label' => 'backend.photo.metatitle'
            // ))
            // ->add('metaDescription', 'textarea', array(
            //     'required' => false,
            //     'label' => 'backend.photo.metadescription'
            // ))
            // ->add('metaKeywords', 'text', array(
            //     'required' => false,
            //     'label' => 'backend.photo.metakeywords'
            // ))
            ->add('file', 'file', array(
                'required' => false,
                'label' => 'backend.photo.img'
            ))
            // ->add('description', 'textarea', array(
            //     'required' => false,
            //     'label' => 'backend.photo.description',
            //     "attr" => array(
            //         "class" => "ckeditor"
            //     )
            // ))
            ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Site\MainBundle\Entity\Photo',
            'translation_domain' => 'menu'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'site_mainbundle_photo';
    }
}
