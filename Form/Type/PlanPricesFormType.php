<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Form\Type;

use Propel\PropelBundle\Form\BaseAbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PlanPricesFormType extends BaseAbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'translation_domain' => 'dzangocart_subscription',
            'data_class' => 'Dzangocart\Bundle\SubscriptionBundle\Propel\Plan',
            'name' => 'dzangocart_subscription_plan_prices',
            'intention' => 'plan_prices'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('prices', 'collection', array(
            'label' => false,
            'type' => new PriceFormType(),
            'allow_add' => false,
            'allow_delete' => false
        ));

        $builder->add('save', 'submit', array(
            'label' => 'plan.form.submit.label'
        ));
    }
}
