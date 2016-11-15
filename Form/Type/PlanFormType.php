<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Form\Type;

use Propel\PropelBundle\Form\BaseAbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextAreaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
            'intention' => 'plan_edit',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, array(
            'label' => 'plan.form.name.label',
        ));

        $builder->add('description', TextAreaType::class, array(
            'label' => 'plan.form.description.label',
            'required' => false,
            'attr' => array(
                'rows' => 12,
            ),
        ));

        $builder->add('start', DateType::class, array(
            'label' => 'plan.form.from.label',
            'widget' => 'single_text',
            'required' => false,
            'attr' => array(
                'class' => 'date start',
                'data-date-format' => 'YYYY-MM-DD',
            ),
        ));

        $builder->add('finish', DateType::class, array(
            'label' => 'plan.form.to.label',
            'widget' => 'single_text',
            'required' => false,
            'attr' => array(
                'class' => 'date finish',
                'data-date-format' => 'YYYY-MM-DD',
            ),
        ));

        $builder->add('save', SubmitType::class, array(
            'label' => 'plan.form.submit.label',
        ));
    }

    public function getName()
    {
        return 'dzangocart_subscription_plan';
    }
}
