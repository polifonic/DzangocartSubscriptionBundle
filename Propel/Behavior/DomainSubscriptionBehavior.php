<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Propel\Behavior;

use Behavior;

class DomainSubscriptionBehavior extends Behavior
{
    protected $parameters = array(
        'domain_column' => 'domain',
        'host_column' => 'host'
    );

    public function modifyTable()
    {
        if (!$this->getTable()->containsColumn($this->getParameter('domain_column'))) {
            $this->getTable()->addColumn(array(
                'name' => $this->getParameter('domain_column'),
                'type' => 'VARCHAR',
                'size' => '100',
                'required' => 'true'
            ));
        }

        if (!$this->getTable()->containsColumn($this->getParameter('host_column'))) {
            $this->getTable()->addColumn(array(
                'name' => $this->getParameter('host_column'),
                'type' => 'VARCHAR'
            ));
        }
    }
}
