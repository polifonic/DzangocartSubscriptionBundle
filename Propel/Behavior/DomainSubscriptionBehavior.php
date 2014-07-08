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
            $domain_splitedby_ = explode('_', $this->getParameter('domain_column'));
            $domain_column_phpname = '';

            foreach ($domain_splitedby_ as $x) {
                $domain_column_phpname = $domain_column_phpname . ucfirst($x);
            }

            $this->getTable()->addColumn(array(
                'name' => $this->getParameter('domain_column'),
                'phpName' => $domain_column_phpname,
                'type' => 'VARCHAR',
                'size' => '100',
                'required' => 'true'
            ));
        }

        if (!$this->getTable()->containsColumn($this->getParameter('custom_column'))) {
            $custom_splittedby_ = explode('_', $this->getParameter('custom_column'));
            $custom_column_phpname = '';

            foreach ($custom_splittedby_ as $x) {
                $custom_column_phpname = $custom_column_phpname . ucfirst($x);
            }

            $this->getTable()->addColumn(array(
                'name' => $this->getParameter('custom_column'),
                'phpName' => $custom_column_phpname,
                'type' => 'VARCHAR',
                'size' => '132'
            ));
        }
    }

    public function objectMethods(PHP5ObjectBuilder $builder)
    {
        $custom_column_name = $this->getTable()->getColumn($this->getParameter('custom_column'))->getPhpName();
        $domain_column_name = $this->getTable()->getColumn($this->getParameter('domain_column'))->getPhpName();

        return '
/**
 * Returns the fully qualified hostname of the subscription account
 */
public function getHostname($host)
{
    if (!$this->get'    . $custom_column_name .    '() == null) {
        return $this->get'    . $custom_column_name .    '();
    }

    return $this->get'    . $domain_column_name .    '() . \'.\' . $host;

}';
    }
}
