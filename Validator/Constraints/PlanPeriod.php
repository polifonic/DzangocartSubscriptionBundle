<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class PlanPeriod extends Constraint
{
    protected $message = 'plan.period.invalid.start_greater_than_finish';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

    public function getMessage()
    {
        return $this->message;
    }
}
