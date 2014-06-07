<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Form\Type;

use Propel\PropelBundle\Form\BaseAbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PriceFormType extends BaseAbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'translation_domain' => 'dzangocart_subscription',
            'data_class' => 'Dzangocart\Bundle\SubscriptionBundle\Propel\Price',
            'name' => 'dzangocart_subscription_price'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /*
        $builder->add('definition', 'model', array(
            'class' => 'Dzangocart\Bundle\SubscriptionBundle\Propel\PlanFeatureDefinition',
            'property' => 'name',
            'label' => 'feature.label'
        ));

        $builder->add('value', 'text', array(
            'label' => 'feature.value.label'
        ));

        $builder->add('unit', 'model', array(
            'class' => 'Dzangocart\Bundle\SubscriptionBundle\Propel\PlanUnit',
            'property' => 'name',
            'query' => $this->getUnitQuery(),
            'label' => 'feature.unit.label',
            'required' => false
        ));

        $builder->add('period', 'model', array(
            'class' => 'Dzangocart\Bundle\SubscriptionBundle\Propel\PlanPeriod',
            'property' => 'name',
            'query' => $this->getPeriodQuery(),
            'label' => 'feature.period.label',
            'required' => false
        ));

        */
    }

    public function getName()
    {
        return "plan_price";
    }
/*
    protected function getUnitQuery()
    {
        return \Dzangocart\Bundle\SubscriptionBundle\Propel\PlanUnitQuery::create()
            ->joinWithI18n($this->locale);
    }

    protected function getPeriodQuery()
    {
        return \Dzangocart\Bundle\SubscriptionBundle\Propel\PlanPeriodQuery::create()
            ->joinWithI18n($this->locale);
    }
*/
}
