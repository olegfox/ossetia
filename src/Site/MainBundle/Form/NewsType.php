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

class NewsType extends AbstractType
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
                'label' => 'backend.news.title'
            ))
            ->add('date', null, array(
                'required' => true,
                'label' => 'backend.news.date'
            ))
            ->add('type', ChoiceType::class, array(
                'required' => true,
                'label' => 'backend.news.type',
                'choices' => array(
                    'backend.news.type_choice.official' => 0,
                    'backend.news.type_choice.quickly' => 1,
                    'backend.news.type_choice.meeting' => 2,
                    'backend.news.type_choice.point_view' => 3,
                    'backend.news.type_choice.analytics' => 4,
                    'backend.news.type_choice.stock' => 5,
                )
            ))
            ->add('flag', ChoiceType::class, array(
                'required' => true,
                'label' => 'backend.news.flag',
                'choices' => array(
                    'backend.news.flag_choice.type1' => 0,
                    'backend.news.flag_choice.type2' => 1
                )
            ))
            ->add('metaTitle', TextType::class, array(
                'required' => false,
                'label' => 'backend.news.metatitle'
            ))
            ->add('metaDescription', TextareaType::class, array(
                'required' => false,
                'label' => 'backend.news.metadescription'
            ))
            ->add('metaKeywords', TextType::class, array(
                'required' => false,
                'label' => 'backend.news.metakeywords'
            ))
            ->add('description', TextareaType::class, array(
                'required' => false,
                'label' => 'backend.news.description'
            ))
            ->add('text', TextareaType::class, array(
                'required' => false,
                'label' => 'backend.news.text',
                "attr" => array(
                    "class" => "ckeditor"
                )
            ))
            ->add('file', FileType::class, array(
                'required' => false,
                'label' => 'backend.news.img'
            ))
//            ->add('gallery', FileType::class, array(
//                'required' => false,
//                'label' => 'backend.news.photos',
//                'attr' => array(
//                    'class' => 'uploadify',
//                    'multiple' => true
//                )
//            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Site\MainBundle\Entity\News'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'site_mainbundle_news';
    }
}
