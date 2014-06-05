<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Form\Type;

use Propel\PropelBundle\Form\BaseAbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PlanFormType extends BaseAbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'name' => 'plan_form',
            'translation_domain' => 'plan',
            'show_legend' => false
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
            'label' => 'plan.plans.name'
        ));

        $builder->add('description', 'text', array(
            'label' => 'plan.plans.description'
        ));

        $builder->add('start', 'date', array(
            'label' => 'plan.plans.from'
        ));
        
        $builder->add('finish', 'date', array(
            'label' => 'plan.plans.to'
        ));
        
        $builder->add('plan_features', 'collection', array(
            'type'          => new PlanFeatureFormType(),
            'allow_add'     => true,
            'allow_delete'  => true,
            'by_reference'  => false
        ));
        
        $builder->add('save', 'submit', array(
            'label' => 'plan.plans.actions.save'
        )); 
    }

    public function getName()
    {
        return "plan_form";
    }
}
