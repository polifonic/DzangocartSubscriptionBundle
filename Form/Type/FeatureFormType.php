<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Form\Type;

use Propel\PropelBundle\Form\BaseAbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextAreaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FeatureFormType extends BaseAbstractType
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'translation_domain' => 'dzangocart_subscription',
            'data_class' => 'Dzangocart\Bundle\SubscriptionBundle\Propel\Feature',
            'name' => 'dzangocart_subscription_feature',
            'intention' => 'feature',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, array(
            'label' => 'feature.form.name.label',
        ));

        $builder->add('property_name', TextType::class, array(
            'label' => 'feature.form.property_name.label',
        ));

        $builder->add('description',  TextAreaType::class, array(
            'label' => 'feature.form.description.label',
            'attr' => array(
                'rows' => 12,
            ),
        ));

        $builder->add('submit', SubmitType::class, array(
            'label' => 'feature.form.submit',
        ));
    }
}
