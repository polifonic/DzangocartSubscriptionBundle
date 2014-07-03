<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Propel\Behavior;

use Behavior;

class DomainSubscriptionBehavior extends Behavior
{
    protected $parameters = array(
        'domain_column' => 'domain',
        'host_column' => 'host',
        'custom_column' => 'custom'
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
                'type' => 'VARCHAR',
                'size' => '100'
            ));
        }
    }

    public function objectMethods(PHP5ObjectBuilder $builder)
    { 
    return '
/**
 * Returns the fully qualified hostname of the subscription account
 */
public function getHostname($host)
{
    if (!$this->get'.ucfirst($this->getParameter('custom_column')).'() == null ) {
        return $this->getCustom();
    } else {
        return $this->get'.ucfirst($this->getParameter('domain_column')).'().\'.\'.$host;
    }
}';
    }
}
