<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Form\Type;

use Dzangocart\Bundle\SubscriptionBundle\Propel\PeriodQuery;

use Propel\PropelBundle\Form\BaseAbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PriceFormType extends BaseAbstractType
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
            'data_class' => 'Dzangocart\Bundle\SubscriptionBundle\Propel\Price',
            'name' => 'dzangocart_subscription_price'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('currency', 'text', array());

        $builder->add('price', 'text', array());

        $builder->add('start', 'date', array(
            'widget' => 'single_text',
            'attr' => array(
                'class' => 'date start',
                'data-date-format' => 'YYYY-MM-DD'
            )
        ));

        $builder->add('finish', 'date', array(
            'widget' => 'single_text',
            'attr' => array(
                'class' => 'date finish',
                'data-date-format' => 'YYYY-MM-DD'
            )
        ));

        $builder->add('period', 'model', array(
            'class' => 'Dzangocart\Bundle\SubscriptionBundle\Propel\Period',
            'property' => 'name',
            'query' => PeriodQuery::create()
                ->joinWithI18n($this->getLocale()
            ),
            'required' => false
        ));

        $builder->add('isdefault', 'choice', array(
            'choices'   => array('1' => 'plan.prices.default.true', '0' => 'plan.prices.default.false'),
            'required'  => false,
        ));
    }
}
