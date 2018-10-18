<?php

namespace OC\AuthBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class evenementType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nom',TextType::class)
        ->add('type',ChoiceType::class, array(
    'choices'  => array(
        
        'entier' => 'entier',
        'jour séparé' => 'jour',
    ),
))
        ->add('dateDebut',DateType::class)
        ->add('dateFin',DateType::class)
        ->add('publie',ChoiceType::class, array(
    'choices'  => array(
        
        'true' => true,
        'false' => false,
    ),
))
        ->add('save', SubmitType::class, array('label' => 'création de votre événement '));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'OC\AuthBundle\Entity\evenement'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'oc_authbundle_evenement';
    }


}
