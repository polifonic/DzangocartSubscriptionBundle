<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Form\Type;

use Propel\PropelBundle\Form\BaseAbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FeatureFormType extends BaseAbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'translation_domain' => 'dzangocart_subscription',
            'data_class' => 'Dzangocart\Bundle\SubscriptionBundle\Propel\Feature',
            'name' => 'dzangocart_subscription_feature',
            'intention' => 'feature'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
            'label' => 'feature.form.name.label'
        ));

        $builder->add('description', 'textarea', array(
            'label' => 'feature.form.description.label',
            'attr' => array(
                'rows' => 12
            )
        ));

        $builder->add('submit', 'submit', array(
            'label' => 'feature.form.submit'
        ));
    }
}
