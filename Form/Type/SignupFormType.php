<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Form\Type;

use Dzangocart\Bundle\SubscriptionBundle\Propel\Plan;
use Dzangocart\Bundle\SubscriptionBundle\Propel\PlanQuery;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SignupFormType extends AbstractType
{
    protected $class;
	protected $locale;
	protected $trial_enabled;
	protected $trial_options_enabled;

    /**
     * @param string $class The class name of the
     */
    public function __construct(RequestStack $request_stack, $class, array $config)
    {
        $this->class = $class;
		$this->locale = $request_stack->getCurrentRequest()->getLocale();
		$this->trial_enabled = $config['enabled'];
		$this->trial_options_enabled = $config['options'];
    }

	public function getLocale()
	{
		return $this->locale;
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
            'label' => 'signup.form.plan_id.label',
            'choices' => $this->getPlans(),
            'required' => true,
            'preferred_choices' => Plan::getDefaultPlan()? array(Plan::getDefaultPlan()->getId()): $this->getPlans(),
            'label_attr' => array(
                'class' => 'sr-only'
            )
        ));

        $builder->add('submit', 'submit', array());
    }

    public function getName()
    {
        return 'dzangocart_subscription_signup';
    }

    protected function getPlans()
    {
        $plans = array();

        $query = PlanQuery::create()
            ->joinWithI18n($this->getLocale())
            ->getActive()
            ->orderByRank();

		if ($this->trial_enabled) {
			$trial_plan = $query
				->filterByTrial(true)
				->findOne();
		}

        foreach ($query->find() as $plan) {
            $plans[$plan->getId()] = $plan->getName();
        }

        return $plans;
    }
}
