<?php

namespace AppBundle\Form;

use AppBundle\Entity\Cliente;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClienteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstname')->add('lastname')->add('dni')->add('email')        ;

        /**
         * Uppercase data client for firtname and lastname
         */
        $builder->addEventListener(FormEvents::POST_SUBMIT, [$this, 'upperCaseFirstnameLastname']);

    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Cliente'
        ));
    }

    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault([
            'data_class' => Cliente::class,
            'csrf_protection' => false
        ]);
    }

    public function getDefaultOptions($options)
    {
        return [
            'csrf_protection' => false
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_cliente';
    }

    /**
     * Callback to uppercase firstname and lastname of Cliente
     * @param FormEvent $event
     */
    public function upperCaseFirstnameLastname(FormEvent $event)
    {
        /**
         * @var $client Cliente
         */
        $client = $event->getData();

        $client->setFirstname(strtoupper($client->getFirstname()));
        $client->setLastname(strtoupper($client->getLastname()));
    }



}
