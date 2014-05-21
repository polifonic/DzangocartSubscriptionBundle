<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Dzangocart\SubscriptionBundle\Model\PlanQuery;

/**
 * @Route("/plan")
 * @Template
 */
class PlanController extends Controller
{
    /**
     * Lists all Plans.
     *
     * @Route("/", name="plans")
     */
    public function indexAction()
    {
        $plans = $this->getQuery()->
              find();

        return array(
            'plans' => $plans
        );
    }

        /**
         * Finds and displays a Plan entity.
         *
         * @Route("/show/{id}", name="plan_show")
         */
        public function showAction($id)
        {
        }

        /**
         * Displays a form to edit an existing Plan entity.
         *
         */
        public function editAction($id)
        {
        }

        /**
         * Deletes a Plan entity.
         *
         */
        public function deleteAction($id)
        {
        }

    protected function getQuery()
    {
        return PlanQuery::create()->
            joinWithI18n($this->getRequest()->getLocale());
    }

}
