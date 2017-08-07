<?php

namespace BusBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WebServiceType extends ServiceType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
          ->add('secure')
          ->add('methods', ChoiceType::class, ['multiple' => true, 'choices' => ['GET' => 'GET', 'POST' => 'POST'], 'expanded' => true]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults(
          array(
            'data_class' => 'BusBundle\Entity\WebService',
          )
        );
    }
}
