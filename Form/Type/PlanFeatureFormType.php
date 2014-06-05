<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Form\Type;

use Propel\PropelBundle\Form\BaseAbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PlanFeatureFormType extends BaseAbstractType
{
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
            'label' => 'Feature'
            //'index_property' => 'slug' /** If you want to use a specifiq unique column for key to not expose the PK **/
        ));
        
        $builder->add('value', 'text', array(
            'label' => 'Value'
        ));
        
        $builder->add('unit', 'model', array(
            'class' => 'Dzangocart\Bundle\SubscriptionBundle\Propel\PlanUnit',
            'property' => 'name',
            //'query' => \Dzangocart\Bundle\SubscriptionBundle\Propel\PlanUnitI18nQuery::create(),
            'label' => 'Unit'
            //'index_property' => 'slug' /** If you want to use a specifiq unique column for key to not expose the PK **/
        ));
        
        $builder->add('period', 'model', array(
            'class' => 'Dzangocart\Bundle\SubscriptionBundle\Propel\PlanPeriod',
            'property' => 'name',
            'label' => 'Period'
            //'index_property' => 'slug' /** If you want to use a specifiq unique column for key to not expose the PK **/
        ));

    }

    public function getName()
    {
        return "plan_feature_form";
    }
}