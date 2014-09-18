<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class AlphaNumericValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {

        if (!preg_match('/^\w+$/', $value, $matches) && !$value == '') {
            $this->context->addViolation($constraint->getMessage());
        }
    }
}
