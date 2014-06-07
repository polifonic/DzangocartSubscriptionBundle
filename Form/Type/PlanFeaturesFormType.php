<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Form\Type;

use Propel\PropelBundle\Form\BaseAbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PlanFeaturesFormType extends BaseAbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'translation_domain' => 'dzangocart_subscription',
            'data_class' => 'Dzangocart\Bundle\SubscriptionBundle\Propel\Plan',
            'name' => 'dzangocart_subscription_plan_features',
            'intention' => 'plan_features'
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
            'label' => 'plan.form.submit.label'
        ));
    }
}
