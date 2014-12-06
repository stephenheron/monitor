<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Entity\Address;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('company', null, ['required' => false])
            ->add('addressLine1', null, ['required' => true])
            ->add('addressLine2', null, ['required' => false])
            ->add('addressLine3', null, ['required' => false])
            ->add('town', null, ['required' => true])
            ->add('postalCode', null, ['required' => true])
            ->add('country', 'country', ['required' => true]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Address'
        ));
    }

    public function getName()
    {
        return 'address';
    }
}