<?php

namespace Site\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SliderType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('position', null, array(
                'required' => false,
                'label' => 'backend.slider.position',
                'attr' => array(
                    'min' => 0
                )
            ))
            ->add('file', 'file', array(
                'required' => false,
                'label' => 'backend.slider.img'
            ))
            ->add('main', 'choice', array(
                'required' => true,
                'label' => 'backend.slider.main',
                'choices' => array(
                    0 => 'backend.slider.main_no',
                    1 => 'backend.slider.main_yes'
                ),
                'translation_domain' => 'menu'
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Site\MainBundle\Entity\Slider',
            'translation_domain' => 'menu'
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
