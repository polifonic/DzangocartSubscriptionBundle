<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PlanPeriodValidator extends ConstraintValidator
{
    public function validate($object, Constraint $constraint)
    {
        $start = $object->getStart();
        $finish = $object->getFinish();

        if ($start > $finish) {
            $this->context->addViolation(
                $constraint->getMessage(),
                array()
            );
        }
    }
}
