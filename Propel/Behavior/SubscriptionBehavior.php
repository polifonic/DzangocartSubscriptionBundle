<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Propel\Behavior;

use Behavior;
use ForeignKey;
use Propel;

class SubscriptionBehavior extends Behavior
{
    protected $dbname;
    protected $conn;
    protected $tblname;

    protected function setDbName()
    {
        $con_string = Propel::getConfiguration()['datasources'][$this->getTable()->getDatabase()->getName()]['connection']['dsn'];
        $start = strpos($con_string, 'dbname=') + 7;
        $db_block = substr($con_string, $start);
        $this->dbname = substr($db_block, 0, strpos($db_block, ';'));
    }

    protected function setConnection()
    {
        $this->conn = Propel::getConnection();
    }

    protected function setTblName()
    {
        $this->tblname = $this->getTable()->getName();
    }

    protected $parameters = array(
        'plan_id_column' => 'plan_id',
        'expires_at_column' => 'expires_at',
        'create_plan_id_column' => 'false',
        'create_expires_at_column' => 'false',
        'populate_plan_id_column' => 'false'
    );

    public function modifyTable()
    {
        $this->setDbName();
        $this->setConnection();
        $this->setTblName();

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

        if (strtolower($this->getParameter('create_plan_id_column')) == 'true') {
            $this->createPlanColumn();
        }

        if (strtolower($this->getParameter('create_expires_at_column')) == 'true') {
            $this->createExpiresAtColumn();
        }

        if (strtolower($this->getParameter('populate_plan_id_column')) == 'true') {
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
        if ($this->existsColumn($this->getParameter('plan_id_column'), $this->tblname, $this->dbname)) {
            $default_plan_id = 1;
            $sql_plan_id = "select id from plan order by rank limit 1";
            $st_plan_id = $this->conn->prepare($sql_plan_id);
            $st_plan_id->execute();
            $plan_id = $st_plan_id->fetchColumn(0);

            if (!$plan_id == null) {
                $default_plan_id = $plan_id;
            }

            $sql = sprintf("update %s set %s = %d where %s = 0 or %s is null;",
                $this->getTable()->getName(),
                $this->getParameter('plan_id_column'),
                $default_plan_id,
                $this->getParameter('plan_id_column'),
                $this->getParameter('plan_id_column')
            );
            $st = $this->conn->prepare($sql);
            $st->execute();
        }
    }

    public function createPlanColumn()
    {
        if ($this->existsTable($this->tblname, $this->dbname) && !$this->existsColumn($this->getParameter('plan_id_column'), $this->tblname, $this->dbname)) {
            $sql = sprintf("alter table %s add %s integer not null",
                $this->getTable()->getName(),
                $this->getParameter('plan_id_column')
            );
            $st = $this->conn->prepare($sql);
            $st->execute();
            $this->populatePlanColumn();
        }
    }

    public function createExpiresAtColumn()
    {
        if ($this->existsTable($this->tblname, $this->dbname) && !$this->existsColumn($this->getParameter('expires_at_column'), $this->tblname, $this->dbname)) {
            $sql = sprintf("alter table %s add %s date",
                $this->getTable()->getName(),
                $this->getParameter('expires_at_column')
            );
            $st = $this->conn->prepare($sql);
            $st->execute();
        }
    }

    public function existsTable($tblname, $dbname)
    {
        $sql = sprintf('select table_name from information_schema.tables where table_schema = \'%s\' and table_name = \'%s\'',
            $dbname,
            $tblname
        );
        $st = $this->conn->prepare($sql);
        $st->execute();
        return ($st->fetchAll() == null ? false : true);
    }

    public function existsColumn($colname, $tblname, $dbname)
    {
        $sql = sprintf('select table_name from information_schema.columns where table_schema = \'%s\' and table_name = \'%s\' and column_name = \'%s\'',
            $dbname,
            $tblname,
            $colname
        );
        $st = $this->conn->prepare($sql);
        $st->execute();
        return ($st->fetchAll() == null ? false : true);
    }
}
