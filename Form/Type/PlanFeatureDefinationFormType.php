<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Form\Type;

use Propel\PropelBundle\Form\BaseAbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PlanFeatureDefinationFormType extends BaseAbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'name' => 'plan_feature_defination_form',
            'translation_domain' => 'features',
            'show_legend' => false
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', array(
            'label' => 'features.defination.label.name'
        ));

        $builder->add('description', 'text', array(
            'label' => 'features.defination.label.description'
        ));

        $builder->add('rank', 'number', array(
            'label' => 'features.defination.label.rank'
        ));
        
        $builder->add('submit', 'submit', array(
            'label' => 'features.defination.label.submit'
        ));
    }

    public function getName()
    {
        return "plan_feature_defination_form";
    }
}
