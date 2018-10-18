<?php

namespace OC\AuthBundle\Form;


use OC\UserBundle\Entity\User;
use OC\UserBundle\Repository\UserRepository;




use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PresentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
         $pattern = $options['jourID'];
        
        $builder
        
        ->add('users', EntityType::class, array(
            'class' => 'OCUserBundle:User',
            'choice_label'=>'username',
            'multiple' => true,
            'expanded' => true,
             'query_builder' => function(UserRepository $repository) use($pattern) {
          return $repository->findUserJour($pattern);
        }
            ))
        ->add('save', SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'OC\AuthBundle\Entity\Present'
        ));
        $resolver->setRequired(['jourID']);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'oc_authbundle_present';
    }


}
