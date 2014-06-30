<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Propel\Behavior;

use Behavior;
use ForeignKey;
use Propel;

class SubscriptionBehavior extends Behavior
{
    protected $parameters = array(
        'plan_id_column'      => 'plan_id',
        'expires_at_column'   => 'expires_at',
        'create_plan_id_column' => 'false',
        'create_expires_at_column' => 'false',
        'populate_plan_id_column' => 'false'
    );

    public function modifyTable()
    {
        if (!$this->getTable()->containsColumn($this->getParameter('plan_id_column'))) {
            $this->getTable()->addColumn(array(
                'name' => $this->getParameter('plan_id_column'),
                'type' => 'INTEGER',
                'required' => 'true'
            ));

            $fk = new ForeignKey();
            $fk->setForeignTableCommonName('plan');
            $fk->setOnDelete(ForeignKey::RESTRICT);
            $fk->addReference($this->getParameter('plan_id_column'), 'id');
            $this->getTable()->addForeignKey($fk);
        }

        if (strtolower($this->getParameter('create_plan_id_column')) == 'true' ) {
            $this->createPlanColumn();
        }

        if (strtolower($this->getParameter('create_expires_at_column')) == 'true' ) {
            $this->createExpiresAtColumn();
        }

        if (strtolower($this->getParameter('populate_plan_id_column')) == 'true' ) {
            $this->populatePlanColumn();
        }

        if (!$this->getTable()->containsColumn($this->getParameter('expires_at_column'))) {
            $this->getTable()->addColumn(array(
                'name' => $this->getParameter('expires_at_column'),
                'type' => 'TIMESTAMP'
            ));
        }
    }
    
    public function populatePlanColumn()
    {
        $default_plan_id = 1;
        $sql_plan_id = "select id from plan order by rank limit 1";
        $conn = Propel::getConnection();
        $st_plan_id = $conn->prepare($sql_plan_id);
        $st_plan_id->execute();
        $plan_id = $st_plan_id->fetchColumn(0);

        if (!$plan_id == null ) {
            $default_plan_id = $plan_id;
        }

        $sql = sprintf("update %s set %s = %d where %s is null;",
            $this->getTable()->getName(),
            $this->getParameter('plan_id_column'),
            $default_plan_id,
            $this->getParameter('plan_id_column')
        );
        $st = $conn->prepare($sql);
        $st->execute();
    }
    
    public function createPlanColumn()
    {
        $conn = Propel::getConnection();
        $con_string = Propel::getConfiguration()['datasources'][$this->getTable()->getDatabase()->getName()]['connection']['dsn'];
        $db_block = explode(';', $con_string)[1];
        $dbname = substr($db_block, 7);

       $sql = sprintf("if not exists (select * from %s where %s is null or %s > 0 )
            begin 
            alter table %s add %s integer not null
            end;",
            $this->getTable()->getName(),
            $this->getParameter('plan_id_column'),
            $db,
            $this->getParameter('plan_id_column')
        );
        $st = $conn->prepare($sql);
        $st->execute();
        $a = $st->fetchAll();
        print_r($a); die;
        $this->populatePlanColumn();
    }
    
    public function existsTable($tblname, $dbname)
    {
        $conn = Propel::getConnection();
        $sql = sprintf('select table_name from information_schema.tables where table_schema = %s and table_name = %s ',
            $dbname,
            $tblname
        );
        $st = $conn->prepare($sql);
        $st->execute();
        return ($st->fetchAll() == null? false : true);
    }
    
    public function existsColumn($colname, $tblname, $dbname)
    {
        $conn = Propel::getConnection();
        $sql = sprintf('select table_name from information_schema.columns where table_schema = %s and table_name = %s and column_name = %s',
            $dbname,
            $tblname,
            $colname
        );
        $st = $conn->prepare($sql);
        $st->execute();
        return ($st->fetchAll() == null? false : true);
    }
}
