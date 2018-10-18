<?php

namespace OC\AuthBundle\Form;



use OC\AuthBundle\Entity\Present;
use OC\AuthBundle\Repository\PresentRepository;



use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserEditType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $pattern = $options['userID'];
        $builder
        ->remove('save', SubmitType::class)
        ->add('presents',EntityType::class, array(
            'class' => 'OCAuthBundle:Present',
            'choice_label'=>'jour',
            'multiple' => true,
            'expanded' => true,
             'query_builder' => function(PresentRepository $repository) use($pattern) {
          return $repository->getJourEvenement($pattern);
        }
            ))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'options' => array(
                    'translation_domain' => 'FOSUserBundle',
                    'attr' => array(
                        'autocomplete' => 'new-password',
                    ),
                ),
                'first_options' => array('label' => 'form.password'),
                'second_options' => array('label' => 'form.password_confirmation'),
                'invalid_message' => 'fos_user.password.mismatch',
            ))
            ->add('save', SubmitType::class);
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
    $resolver->setRequired(['userID']);
    }
    
    public function getParent()
    {
        return 'OC\UserBundle\Form\UserType';

        // Or for Symfony < 2.8
        // return 'fos_user_registration';
    }

    


}