<?php

namespace Site\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class QuoteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('onMain', ChoiceType::class, array(
                'required' => true,
                'label' => 'backend.quote.onMain.label',
                'choices' => array(
                    'Нет' => false,
                    'Да' => true
                )
            ))
            ->add('title', TextType::class, array(
                'required' => true,
                'label' => 'backend.quote.title'
            ))
            ->add('img', TextType::class, array(
                'required' => false,
                'label' => 'backend.quote.img'
            ))
            ->add('file', FileType::class, array(
                'required' => false,
                'label' => 'backend.quote.img'
            ))
            ->add('date', null, array(
                'required' => true,
                'label' => 'backend.quote.date'
            ))
            ->add('metaTitle', TextType::class, array(
                'required' => false,
                'label' => 'backend.quote.metatitle'
            ))
            ->add('metaDescription', TextareaType::class, array(
                'required' => false,
                'label' => 'backend.quote.metadescription'
            ))
            ->add('metaKeywords', TextType::class, array(
                'required' => false,
                'label' => 'backend.quote.metakeywords'
            ))
            ->add('text', TextareaType::class, array(
                'required' => false,
                'label' => 'backend.quote.text',
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
            'data_class' => 'Site\MainBundle\Entity\Quote'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'site_mainbundle_quote';
    }
}
