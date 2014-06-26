<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Form\Type;

use Propel\PropelBundle\Form\BaseAbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FeatureDefinitionFormType extends BaseAbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'name' => 'dzangocart_subscription_feature_definition',
            'translation_domain' => 'dzangocart_subscription'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
            'label' => 'plan.form.name.label'
        ));

        $builder->add('description', 'textarea', array(
            'label' => 'plan.form.description.label',
            'attr' => array(
                'rows' => 12
            )
        ));

        $builder->add('submit', 'submit', array(
            'label' => 'plan.form.submit.label'
        ));
    }
}
