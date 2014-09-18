<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class AlphaNumeric extends Constraint
{
    protected $message = 'The string contains an illegal character: it can only contain letters or numbers or underscore';

    public function getMessage()
    {
        return $this->message;
    }
}
