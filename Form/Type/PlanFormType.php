<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Form\Type;

use Propel\PropelBundle\Form\BaseAbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PlanFormType extends BaseAbstractType
{
    protected $locale;

    public function __construct($locale = 'en')
    {
        $this->locale = $locale;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'translation_domain' => 'dzangocart_subscription',
            'data_class' => 'Dzangocart\Bundle\SubscriptionBundle\Propel\Plan',
            'intention' => 'plan_edit'
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

        $builder->add('description', 'text', array(
            'label' => 'plan.form.description.label'
        ));

        $builder->add('start', 'date', array(
            'label' => 'plan.form.from.label',
            'widget' => 'single_text',
            'required' => false
        ));

        $builder->add('finish', 'date', array(
            'label' => 'plan.form.to.label',
            'widget' => 'single_text',
            'required' => false
        ));

        $builder->add('save', 'submit', array(
            'label' => 'plan.form.submit.label'
        ));
    }

    public function getName()
    {
        return 'dzangocart_subscription_plan';
    }
}
