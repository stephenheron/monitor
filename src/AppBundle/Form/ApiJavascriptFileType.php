<?php

namespace AppBundle\Form;

use AppBundle\Form\AbstractApiResourceType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ApiJavascriptFileType extends AbstractApiResourceType
{

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $this->defaults['data_class'] = 'AppBundle\Entity\JavascriptFile';
        parent::setDefaultOptions($resolver);
    }
}
