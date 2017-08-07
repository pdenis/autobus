<?php

namespace BusBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $serviceChain = $options['service_chain'];

        $serviceClasses = [];
        foreach ($serviceChain->getServices() as $sid => $service) {
            $serviceClasses[$sid] = $sid;
        }

        $builder
          ->add('name')
          ->add('service', ChoiceType::class, ['choices' => $serviceClasses])
          ->add('path')
          ->add('trace')
          ->add('config');
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('service_chain');
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'busbundle_service';
    }
}
