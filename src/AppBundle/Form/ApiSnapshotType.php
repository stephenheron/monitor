<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ApiSnapshotType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('htmlSource', null, ['required' => false])
            ->add('mirrorDirectoryName', null, ['required' => true])
            ->add('har', null, ['required' => false]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Snapshot',
            'csrf_protection' => false
        ));
    }

    public function getName()
    {
        return '';
    }
}
