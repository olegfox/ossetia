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

class NewsPaperType extends AbstractType
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
                'label' => 'backend.news_paper.title'
            ))
            ->add('description', TextareaType::class, array(
                'required' => false,
                'label' => 'backend.news_paper.description'
            ))
            ->add('document', TextType::class, array(
                'required' => false,
                'label' => 'backend.news_paper.document'
            ))
            ->add('fileDocument', FileType::class, array(
                'required' => false,
                'label' => 'backend.news_paper.document'
            ))
            ->add('img', TextType::class, array(
                'required' => false,
                'label' => 'backend.news_paper.img'
            ))
            ->add('file', FileType::class, array(
                'required' => false,
                'label' => 'backend.news_paper.img'
            ))
            ->add('date', null, array(
                'required' => true,
                'label' => 'backend.news_paper.date'
            ))
            ->add('metaTitle', TextType::class, array(
                'required' => false,
                'label' => 'backend.news_paper.metatitle'
            ))
            ->add('metaDescription', TextareaType::class, array(
                'required' => false,
                'label' => 'backend.news_paper.metadescription'
            ))
            ->add('metaKeywords', TextType::class, array(
                'required' => false,
                'label' => 'backend.news_paper.metakeywords'
            ))
            ->add('text', TextareaType::class, array(
                'required' => false,
                'label' => 'backend.news_paper.text',
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
            'data_class' => 'Site\MainBundle\Entity\NewsPaper'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'site_mainbundle_news_paper';
    }
}
