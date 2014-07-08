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
            $domain_array = explode('_', $this->getParameter('domain_column'));
            $domain_phpname = '';

            foreach ($domain_array as $x) {
                $domain_phpname = $domain_phpname . ucfirst($x);
            }

            $this->getTable()->addColumn(array(
                'name' => $this->getParameter('domain_column'),
                'phpName' => $domain_phpname,
                'type' => 'VARCHAR',
                'size' => '100',
                'required' => 'true'
            ));
        }

        if (!$this->getTable()->containsColumn($this->getParameter('custom_column'))) {
            $custom_array = explode('_', $this->getParameter('custom_column'));
            $custom_phpname = '';

            foreach ($custom_array as $x) {
                $custom_phpname = $custom_phpname . ucfirst($x);
            }

            $this->getTable()->addColumn(array(
                'name' => $this->getParameter('custom_column'),
                'phpName' => $custom_phpname,
                'type' => 'VARCHAR',
                'size' => '132'
            ));
        }
    }

    public function objectMethods(PHP5ObjectBuilder $builder)
    {
        $name_for_get_custom = $this->getTable()->getColumn($this->getParameter('custom_column'))->getPhpName();
        $name_for_get_domain = $this->getTable()->getColumn($this->getParameter('domain_column'))->getPhpName();
        $script = sprintf ('
/**
 * Returns the fully qualified hostname of the subscription account
 */
public function getHostname($host)
{
    if (!$this->get%1$s() == null ) {
        return $this->get%1$s();
    }

    return $this->get%2$s().\'.\'.$host;

}', $name_for_get_custom, $name_for_get_domain);
        
        return $script;
    }  
}
