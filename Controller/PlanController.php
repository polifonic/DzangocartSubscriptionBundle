<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Controller;

use Dzangocart\Bundle\SubscriptionBundle\Propel\PlanQuery;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
     * @Template("DzangocartSubscriptionBundle:Plan:index.html.twig")
     */
    public function indexAction()
    {
        $plans = $this->getQuery()
            ->find();

        return array(
            'plans' => $plans
        );
    }

    /**
     * Finds and displays a Plan entity.
     *
     * @Route("/show/{id}", name="plan_show")
     * @Template("DzangocartSubscriptionBundle:Plan:show.html.twig")
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
        return PlanQuery::create()
            ->joinWithI18n($this->getRequest()->getLocale());
    }
}
