<?php

namespace Site\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PageType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                'required' => true,
                'label' => 'backend.page.title'
            ))
            ->add('metaTitle', TextType::class, array(
                'required' => false,
                'label' => 'backend.page.metatitle'
            ))
            ->add('metaDescription', TextareaType::class, array(
                'required' => false,
                'label' => 'backend.page.metadescription'
            ))
            ->add('metaKeywords', TextType::class, array(
                'required' => false,
                'label' => 'backend.page.metakeywords'
            ))
            ->add('text', TextareaType::class, array(
                'required' => false,
                'label' => 'backend.page.text',
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
            'data_class' => 'Site\MainBundle\Entity\Page'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'site_mainbundle_page';
    }
}
