<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Controller;

use Dzangocart\Bundle\SubscriptionBundle\Form\Type\PlanFormType;
use Dzangocart\Bundle\SubscriptionBundle\Propel\PlanQuery;
use Dzangocart\Bundle\SubscriptionBundle\Propel\Plan;

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
     * @Route("/edit/{id}", name="dzangocart_subscription_plans_edit")
     * @Template("DzangocartSubscriptionBundle:Plan:edit.html.twig")
     */
    public function editAction($id)
    {
        return array();
    }

    /**
     * Deletes a Plan entity.
     *
     */
    public function deleteAction($id)
    {
        
    }

    /**
     * Create a Plan entity.
     * 
     * @Route("/create", name="dzangocart_subscription_plan_create")
     * @Template("DzangocartSubscriptionBundle:Plan:create.html.twig")
     */
    public function createAction()
    {
       $form = $this->createForm(
            new PlanFormType(),
            $plan = new Plan(),
            array(
                'action' => $this->generateUrl('dzangocart_subscription_plan_create'))
            );

        return array(
            'form' => $form->createView()
        );
    }

    protected function getQuery()
    {
        return PlanQuery::create()
                ->joinWithI18n($this->getRequest()->getLocale());
    }
}
