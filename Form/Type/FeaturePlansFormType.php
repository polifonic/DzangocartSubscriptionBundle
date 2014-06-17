<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Form\Type;

use Propel\PropelBundle\Form\BaseAbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FeaturePlansFormType extends BaseAbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'translation_domain' => 'dzangocart_subscription',
            'data_class' => 'Dzangocart\Bundle\SubscriptionBundle\Propel\FeatureDefinition',
            'name' => 'dzangocart_subscription_feature_plans',
            'intention' => 'feature_plans'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'features',
            'collection',
            array(
                'label' => false,
                'type' => new FeatureFormType(),
                'allow_add' => false,
                'allow_delete' => false
            )
        );

        $builder->add('save', 'submit', array(
            'label' => 'feature.form.submit.label'
        ));
    }
}
