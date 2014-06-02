<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Propel;

use Criteria;

use Dzangocart\Bundle\SubscriptionBundle\Propel\om\BasePlanFeatureDefinitionQuery;

use Symfony\Component\HttpFoundation\ParameterBag;

class PlanFeatureDefinitionQuery extends BasePlanFeatureDefinitionQuery
{
    public function dataTablesSort(ParameterBag $params, array $columns = array())
    {
        $control = 0;

        for ($i = 0; $i < $params->get('iSortingCols'); $i++) {
            $index = $params->get('iSortCol_' . $i);

            if (array_key_exists($index, $columns)) {
                $sort_columns = $columns[$index];
                $dir = 'desc' == strtolower($params->get('sSortDir_' . $i)) ? Criteria::DESC : Criteria::ASC;

                if (!is_array($sort_columns)) {
                    $sort_columns = array($sort_columns);
                }

                foreach ($sort_columns as $column) {
                    $this->orderBy($column, $dir);
                }

                $control++;
            }

        }

        return $control ? $this : $this->defaultSort();
    }

    function defaultSort()
    {
        return $this->orderById();
    }
}
