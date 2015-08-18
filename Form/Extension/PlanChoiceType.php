<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Form\Extension;

use Dzangocart\Bundle\SubscriptionBundle\Propel\Plan;
use Dzangocart\Bundle\SubscriptionBundle\Propel\PlanQuery;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PlanChoiceType extends AbstractType
{
    protected $request_stack;

    public function __construct(RequestStack $request_stack)
    {
        $this->request_stack = $request_stack;
    }

    public function getParent()
    {
        return 'choice';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => $this->getPlans(),
//            'preferred_choices' => Plan::getDefaultPlan() ? array(Plan::getDefaultPlan()->getId()) : $this->getPlans(),
            'placeholder' => 'plan.choice.placeholder',
            'translation_domain' => 'dzangocart_subscription',
            'required' => true,
        ));
    }

    // BC for SF < 2.7
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $this->configureOptions($resolver);
    }

    public function getName()
    {
        return 'dzangocart_subscription_plan';
    }

    protected function getPlans()
    {
        $plans = PlanQuery::create()
            ->joinWithI18n($this->getLocale())
            ->orderByRank()
            ->find();

        $choices = array();

        foreach ($plans as $plan) {
            $choices[$plan->getId()] = $this->getLabelForPlan($plan);
        }

        return $choices;
    }

    protected function getLabelForPlan(Plan $plan)
    {
        return $plan->getName();

        // FIXME [OP 2015-07-06]
        return sprintf(
            '% (%s)',
            $plan->getName(),
            $plan->getDefaultPrice()->__toString()
        );
    }

    protected function getLocale()
    {
        return $this->getRequestStack()
            ->getCurrentRequest()
            ->getLocale();
    }

    protected function getRequestStack()
    {
        return $this->request_stack;
    }
}
