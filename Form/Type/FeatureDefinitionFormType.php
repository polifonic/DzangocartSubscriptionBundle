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
            'name' => 'fzangocart_subscription_feature_definition',
            'translation_domain' => 'dzangocart_subscription'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
            'label' => 'feature.features.name'
        ));

        $builder->add('description', 'text', array(
            'label' => 'feature.features.description'
        ));

        $builder->add('submit', 'submit', array(
            'label' => 'feature.features.save'
        ));
        /*
          $builder->add('modify', 'submit', array(
          'label' => 'features.definition.modify'
          )); */
    }
}
