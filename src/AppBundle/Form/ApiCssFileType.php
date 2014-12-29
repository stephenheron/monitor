<?php

namespace AppBundle\Form;

use AppBundle\Form\AbstractApiResourceType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ApiCssFileType extends AbstractApiResourceType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('stats', null, ['required' => true]);
        parent::buildForm($builder, $options);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $this->defaults['data_class'] = 'AppBundle\Entity\CssFile';
        parent::setDefaultOptions($resolver);
    }
}
