<?php

namespace Site\MainBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClientType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fio', 'text', array(
                'required' => true,
                'label' => 'backend.client.fio',
                'attr' => array(
                    'ng-model' => 'client.fio',
                    'ng-minlength' => '3'
                )
            ))
            ->add('phone', 'text', array(
                'required' => true,
                'label' => 'backend.client.phone',
                'attr' => array(
                    'ng-model' => 'client.phone'
                )
            ))
            ->add('company', 'text', array(
                'required' => true,
                'label' => 'backend.client.company',
                'attr' => array(
                    'ng-model' => 'client.company',
                    'ng-minlength' => '3'
                )
            ))
            ->add('email', 'email', array(
                'required' => true,
                'label' => 'backend.client.email',
                'attr' => array(
                    'ng-model' => 'client.email',
                    'ng-minlength' => '5',
                    'placeholder' => 'На этот адрес придёт подтверждение'
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
            'data_class' => 'Site\MainBundle\Entity\Client',
            'translation_domain' => 'menu'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'site_mainbundle_client';
    }
}
