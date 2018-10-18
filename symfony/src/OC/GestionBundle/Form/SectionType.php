<?php

namespace OC\GestionBundle\Form;

use OC\GestionBundle\Entity\Section;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SectionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('sSection',EntityType::class, array(
            'class'=>Section::class,
            'choice_label'=>'name',
            'required'=>false,
            'multiple'=>false,
            'expanded'=>true
            ))
        ->add('name',TextType::class)
        ->add('contenu',TextareaType::class)
        ->add('submit',SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'OC\GestionBundle\Entity\Section'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'oc_gestionbundle_section';
    }


}
