<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

abstract class AbstractApiResourceType extends AbstractType
{
    protected $defaults = ['csrf_protection' => false];

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('content', null, ['required' => true]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults($this->defaults);
    }

    public function getName()
    {
        return '';
    }

}
