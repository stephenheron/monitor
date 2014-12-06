<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CustomerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', 'choice', array(
           'choices' => array(
               'Mr'     => 'Mr',
               'Ms'     => 'Ms',
               'Mrs'    => 'Mrs',
               'Miss'   => 'Miss'
           ),
           'required' => true
        )) ;

        $builder
            ->add('firstName', null, ['required' => true])
            ->add('secondName', null, ['required' => true])
            ->add('email', null, ['required' => true])
            ->add('address', new AddressType());
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Customer'
        ));
    }

    public function getName()
    {
        return 'customer';
    }
}