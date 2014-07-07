<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Propel\Behavior;

use Behavior;

class DomainSubscriptionBehavior extends Behavior
{
    protected $had_domain_column = 1;
    protected $had_custom_column = 1;

    protected $parameters = array(
        'domain_column' => 'domain',
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

        if (!$this->getTable()->containsColumn($this->getParameter('custom_column'))) {
            $this->getTable()->addColumn(array(
                'name' => $this->getParameter('custom_column'),
                'type' => 'VARCHAR',
                'size' => '132'
            ));
            $this->had_custom_column = 0;
        }
    }

    public function objectMethods(PHP5ObjectBuilder $builder)
    {
        if ($this->had_domain_column && $this->had_custom_column) {
                $name_for_get_custom = $this->getTable()->getColumn($this->getParameter('custom_column'))->getPhpName();
                $name_for_get_domain = $this->getTable()->getColumn($this->getParameter('domain_column'))->getPhpName();
                return '
/**
 * Returns the fully qualified hostname of the subscription account
 */
public function getHostname($host)
{
    if (!$this->get' . $name_for_get_custom . '() == null ) {
        return $this->get' . $name_for_get_custom . '();
    } else {
        return $this->get' . $name_for_get_domain . '().\'.\'.$host;
    }
}';
        } elseif ($this->had_domain_column && !$this->had_custom_column) {
            $name_for_get_domain = $this->getTable()->getColumn($this->getParameter('domain_column'))->getPhpName();
            return '
/**
 * Returns the fully qualified hostname of the subscription account
 */
public function getHostname($host)
{
    if (!$this->get' . ucfirst($this->getParameter('custom_column')) . '() == null ) {
        return $this->get' . ucfirst($this->getParameter('custom_column')) . '();
    } else {
        return $this->get' . $name_for_get_domain . '().\'.\'.$host;
    }
}';
        } elseif (!$this->had_domain_column && $this->had_custom_column) {
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
    if (!$this->get' . ucfirst($this->getParameter('custom_column')) . '() == null ) {
        return $this->get' . ucfirst($this->getParameter('custom_column')) . '();
    } else {
        return $this->get' . ucfirst($this->getParameter('domain_column')) . '().\'.\'.$host;
    }
}';
        }
    }  
}
