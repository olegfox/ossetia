<?php

namespace Site\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

class SliderType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title1', null, array(
                'required' => false,
                'label' => 'backend.slider.title1'
            ))
            ->add('title2', null, array(
                'required' => false,
                'label' => 'backend.slider.title2'
            ))
            ->add('link', UrlType::class, array(
                'required' => false,
                'label' => 'backend.slider.link'
            ))
            ->add('position', null, array(
                'required' => false,
                'label' => 'backend.slider.position',
                'attr' => array(
                    'min' => 0
                )
            ))
            ->add('file', FileType::class, array(
                'required' => false,
                'label' => 'backend.slider.img'
            ))
            ->add('main', ChoiceType::class, array(
                'required' => true,
                'label' => 'backend.slider.main',
                'choices' => array(
                    'backend.slider.main_no' => 0,
                    'backend.slider.main_yes' => 1
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
            'data_class' => 'Site\MainBundle\Entity\Slider'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'site_mainbundle_slider';
    }
}
