<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Propel\Behavior;

use Behavior;

class DomainSubscriptionBehavior extends Behavior
{
    protected $had_domain_column = 1;

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
            $this->had_domain_column = 0;
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
        if (!$this->had_domain_column) {

            if ($this->getTable()->containsColumn($this->getParameter('custom_column'))) {
                $name_for_get_custom = $this->getTable()->getColumn($this->getParameter('custom_column'))->getPhpName();

                return '
/**
 * Returns the fully qualified hostname of the subscription account
 */
public function getHostname($host)
{
    if (!$this->get' . $name_for_get_custom . '() == null ) {
        return $this->get' . $name_for_get_custom . '();
    } else {
        return $this->get' . ucfirst($this->getParameter('domain_column')) . '().\'.\'.$host;
    }
}';
            } else {
                return '
/**
 * Returns the fully qualified hostname of the subscription account
 */
public function getHostname($host)
{
    return $this->get' . ucfirst($this->getParameter('domain_column')) . '().\'.\'.$host;
}';
            }
        }
    }
}
