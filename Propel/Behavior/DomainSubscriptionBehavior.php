<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Propel\Behavior;

use Behavior;

class DomainSubscriptionBehavior extends Behavior
{
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
        }

        if (!$this->getTable()->containsColumn($this->getParameter('custom_column'))) {
            $this->getTable()->addColumn(array(
                'name' => $this->getParameter('custom_column'),
                'type' => 'VARCHAR',
                'size' => '100'
            ));
        }
    }

    public function objectMethods(PHP5ObjectBuilder $builder)
    {
        $custom_array = explode('_', $this->getParameter('custom_column'));
        $name_for_get_custom = '';

        foreach ($custom_array as $x) {
            $name_for_get_custom = $name_for_get_custom . ucfirst($x);
        }

        $domain_array = explode('_', $this->getParameter('domain_column'));
        $name_for_get_domain = '';

        foreach ($domain_array as $x) {
            $name_for_get_domain = $name_for_get_domain . ucfirst($x);
        }

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
    }
}
