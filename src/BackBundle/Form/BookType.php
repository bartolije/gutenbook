<?php

namespace BackBundle\Form;

use BackBundle\Entity\Book;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('author', TextType::class)
            ->add('editor', TextType::class)
            ->add('categories', EntityType::class, array(
                'class' => 'BackBundle:Category',
                'choice_label' => 'name',
                'multiple' => true
            ))
            ->add('themes', EntityType::class, array(
                'class' => 'BackBundle:Theme',
                'choice_label' => 'name',
                'multiple' => true
            ))
            ->add('publishedAt', DateType::class)
            ->add('summary', TextType::class)
            ->add('save', SubmitType::class, array('label' => 'Create book'))
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BackBundle\Entity\Book'
        ));
    }
}