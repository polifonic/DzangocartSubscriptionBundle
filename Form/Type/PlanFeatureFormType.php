<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Form\Type;

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

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'name' => 'plan_feature_form',
            'translation_domain' => 'feature',
            'show_legend' => false,
            'data_class' => 'Dzangocart\Bundle\SubscriptionBundle\Propel\PlanFeature'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('definition', 'model', array(
            'class' => 'Dzangocart\Bundle\SubscriptionBundle\Propel\PlanFeatureDefinition',
            'property' => 'name',
            'label' => 'feature.label'
            //'index_property' => 'slug' /** If you want to use a specifiq unique column for key to not expose the PK **/
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
            //'index_property' => 'slug' /** If you want to use a specifiq unique column for key to not expose the PK **/
        ));

        $builder->add('period', 'model', array(
            'class' => 'Dzangocart\Bundle\SubscriptionBundle\Propel\PlanPeriod',
            'property' => 'name',
            'query' => $this->getPeriodQuery(),
            'label' => 'feature.period.label',
            'required' => false
            //'index_property' => 'slug' /** If you want to use a specifiq unique column for key to not expose the PK **/
        ));
    }

    public function getName()
    {
        return "plan_feature_form";
    }

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
}
