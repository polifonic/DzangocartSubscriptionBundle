<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SignupFormType extends AbstractType
{
    protected $class;

    /**
     * @param string $class The class name of the
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->class,
            'intention'  => 'signup'
        ));
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('plan_id', 'choice', array(
            'choices' => $this->getPlans(),
            'required' => true
        ));

        $builder->add('submit', 'submit', array());
    }

    public function getName()
    {
        return 'dzangocart_subscription_signup';
    }
}
