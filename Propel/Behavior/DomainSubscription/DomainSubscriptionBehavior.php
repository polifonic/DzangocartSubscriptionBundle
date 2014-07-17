<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Propel\Behavior\DomainSubscription;

use Behavior;
use EngineException;
use Unique;

class DomainSubscriptionBehavior extends Behavior
{
    protected $parameters = array(
        'domain_column' => 'domain',
        'custom_column' => 'custom'
    );

    public function modifyTable()
    {
        if (in_array('hostname', array_map('strtolower', $this->parameters))) {
            throw new EngineException('The DomainSubscription behavior cannot be applied with parameter set to "hostname"');
        } else if ($this->getTable()->getColumn('hostname', true)) {
            throw new EngineException('The DomainSubscription behavior does not support table with column "hostname"');
        } else {
            if (!$this->getTable()->containsColumn($this->getParameter('domain_column'))) {
                $this->getTable()->addColumn(array(
                    'name' => $this->getParameter('domain_column'),
                    'type' => 'VARCHAR',
                    'size' => '100',
                    'required' => 'true'
                ));

                $domain_column = $this->getTable()->getColumn($this->getParameter('domain_column'));

                $unique_domain = new Unique('dzangocart_subscription_domain');
                $unique_domain->setColumns(array (
                    $domain_column
                ));

                $this->getTable()->addUnique($unique_domain);

            }

            if (!$this->getTable()->containsColumn($this->getParameter('custom_column'))) {
                $this->getTable()->addColumn(array(
                    'name' => $this->getParameter('custom_column'),
                    'type' => 'VARCHAR',
                    'size' => '132'
                ));

                $custom_column = $this->getTable()->getColumn($this->getParameter('custom_column'));
                $index_columns = array(
                    $custom_column
                );

                $unique = new Unique('dzangocart_subscription_custom');
                $unique->setColumns($index_columns);

                $this->getTable()->addUnique($unique);
            }
        }
    }

    public function objectMethods($builder)
    {
        $custom_column_name = $this->getTable()->getColumn($this->getParameter('custom_column'))->getPhpName();
        $domain_column_name = $this->getTable()->getColumn($this->getParameter('domain_column'))->getPhpName();

        return '
/**
 * Returns the fully qualified hostname of the subscription account
 */
public function getHostname($host)
{
    return ($custom = $this->get' . $custom_column_name . '())
        ? $custom
        : sprintf(\'%s.%s\', $this->get' . $domain_column_name . '(), $host);

}';
    }
}
