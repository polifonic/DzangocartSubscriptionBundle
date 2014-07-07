<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Form\Type;

use Propel\PropelBundle\Form\BaseAbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FeaturePlansFormType extends BaseAbstractType
{
    protected $locale;

    public function __construct($locale)
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
            'data_class' => 'Dzangocart\Bundle\SubscriptionBundle\Propel\Feature',
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
            'plan_features',
            'collection',
            array(
                'label' => false,
                'type' => new PlanFeatureFormType($this->getLocale()),
                'allow_add' => false,
                'allow_delete' => false
            )
        );

        $builder->add('save', 'submit', array(
            'label' => 'feature.plans.submit'
        ));
    }
}
