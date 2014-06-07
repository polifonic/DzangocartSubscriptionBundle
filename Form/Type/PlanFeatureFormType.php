<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Form\Type;

use Dzangocart\Bundle\SubscriptionBundle\Propel\PlanPeriodQuery;
use Dzangocart\Bundle\SubscriptionBundle\Propel\PlanUnitQuery;

use Propel\PropelBundle\Form\BaseAbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PlanFeatureFormType extends BaseAbstractType
{
    protected $locale;

    public function __construct($locale = 'en')
    {
        $this->locale = $locale;
    }

    public function getLocale()
    {
        return $this->locale;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'translation_domain' => 'dzangocart_subscription',
            'data_class' => 'Dzangocart\Bundle\SubscriptionBundle\Propel\PlanFeature'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('value', 'text', array(
            'label' => false
        ));

        $builder->add('unit', 'model', array(
            'class' => 'Dzangocart\Bundle\SubscriptionBundle\Propel\PlanUnit',
            'property' => 'name',
            'query' => $this->getUnitQuery(),
            'label' => false,
            'required' => false
        ));

        $builder->add('period', 'model', array(
            'class' => 'Dzangocart\Bundle\SubscriptionBundle\Propel\PlanPeriod',
            'property' => 'name',
            'query' => $this->getPeriodQuery(),
            'label' => false,
            'required' => false
        ));
    }
    public function getName()
    {
        return 'dzangocart_subscription_plan_feature';
    }

    protected function getUnitQuery()
    {
        return PlanUnitQuery::create()
            ->joinWithI18n($this->getLocale());
    }

    protected function getPeriodQuery()
    {
        return PlanPeriodQuery::create()
            ->joinWithI18n($this->getLocale());
    }
}
