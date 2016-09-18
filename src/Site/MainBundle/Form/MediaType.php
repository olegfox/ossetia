<?php

namespace Site\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

class MediaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('created', null, array(
                'required' => false,
                'label' => 'backend.media.created'
            ))
            ->add('title', null, array(
                'required' => false,
                'label' => 'backend.media.title'
            ))
            ->add('description', null, array(
                'required' => false,
                'label' => 'backend.media.description'
            ))
            ->add('file', FileType::class, array(
                'required' => false,
                'label' => 'backend.media.preview'
            ))
            ->add('metaTitle', null, array(
                'required' => false,
                'label' => 'backend.media.metaTitle'
            ))
            ->add('metaDescription', TextareaType::class, array(
                'required' => false,
                'label' => 'backend.media.metaDescription'
            ))
            ->add('metaKeywords', null, array(
                'required' => false,
                'label' => 'backend.media.metaKeywords'
            ))
            ->add('videoUrl', UrlType::class, array(
                'required' => false,
                'label' => 'backend.media.video'
            ))
            ->add('gallery', FileType::class, array(
                'required' => false,
                'label' => 'backend.media.photos',
                'attr' => array(
                    'class' => 'uploadify',
                    'multiple' => true
                )
            ))
            ->add('text', TextareaType::class, array(
                'required' => false,
                'label' => 'backend.media.text',
                "attr" => array(
                    "class" => "ckeditor"
                )
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Site\MainBundle\Entity\Media'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'site_mainbundle_media';
    }
}
