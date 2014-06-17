<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Behavior;

use Behavior;

class SubscriptionBehavior extends Behavior
{
    protected $parameters = array(
        'plan_column'      => 'plan_id',
        'expires_column'      => 'expires_at'
    );
    
    public function modifyTable()
    {

        if (!$this->getTable()->containsColumn($this->getParameter('plan_column'))) {
            $this->getTable()->addColumn(array(
                'name' => $this->getParameter('plan_column'),
                'type' => 'INTEGER'
            ));
        }

        if (!$this->getTable()->containsColumn($this->getParameter('expires_column'))) {
            $this->getTable()->addColumn(array(
                'name' => $this->getParameter('expires_column'),
                'type' => 'TIMESTAMP'
            ));
        }

    }
}

