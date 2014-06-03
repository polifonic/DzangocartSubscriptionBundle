<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Controller;

use Dzangocart\Bundle\SubscriptionBundle\Form\Type\PlanFormType;
use Dzangocart\Bundle\SubscriptionBundle\Propel\PlanQuery;
use Dzangocart\Bundle\SubscriptionBundle\Propel\Plan;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/plan")
 * @Template
 */
class PlanController extends Controller
{
    /**
     * Lists all Plans.
     *
     * @Route("/", name="dzangocart_subscription_plans")
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
     * @Route("/show/{id}", name="dzangocart_subscription_plan_show")
     * @Template("DzangocartSubscriptionBundle:Plan:show.html.twig")
     */
    public function showAction($id)
    {
        $entity = $this->getQuery()
            ->findPk($id);
        
        if ($entity) {
            return array (
                'entity' => $entity
            );
        } else {
            return $this->redirect($this->generateUrl('dzangocart_subscription_plans'));
        } 
        
    }

    /**
     * Displays a form to edit an existing Plan entity.
     * 
     * @Route("/edit/{id}", name="dzangocart_subscription_plan_edit")
     * @Template("DzangocartSubscriptionBundle:Plan:edit.html.twig")
     */
    public function editAction($id, Request $request)
    {
        $entity = $this->getQuery()
            ->findPk($id);
        
        if ($entity) {
            $form = $this->createForm(
                new PlanFormType(),
                $entity,
                array(
                    'action' => $this->generateUrl('dzangocart_subscription_plan_edit', array('id' => $id)))
                );

            $form->handleRequest($request);
        
            if ($form->isValid()) {
                $entity->save();
                return $this->redirect($this->generateUrl('dzangocart_subscription_plans'));
            }
            
            return array(
                'form' => $form->createView()
            );
        } else {
            return $this->redirect($this->generateUrl('dzangocart_subscription_plans'));
        }

    }

    /**
     * Delete existing Plan entity.
     * 
     * @Route("/delete/{id}", name="dzangocart_subscription_plan_delete")
     * @Template()
     */
    public function deleteAction($id)
    {
        $entity = $this->getQuery()
            ->findPk($id);

        if ($entity) {
            $entity->delete();
        }
        
        return $this->redirect($this->generateUrl('dzangocart_subscription_plans'));

    }

    /**
     * Create a Plan entity.
     * 
     * @Route("/create", name="dzangocart_subscription_plan_create")
     * @Template("DzangocartSubscriptionBundle:Plan:create.html.twig")
     */
    public function createAction(Request $request)
    {
       $form = $this->createForm(
            new PlanFormType(),
            $plan = new Plan(),
            array(
                'action' => $this->generateUrl('dzangocart_subscription_plan_create'))
            );

        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $plan->save();
            return $this->redirect($this->generateUrl('dzangocart_subscription_plans'));
        }
            
        return array(
            'form' => $form->createView()
        );
    }

    protected function getQuery()
    {
        return PlanQuery::create()
            ->joinWithI18n($this->getRequest()->getLocale())
            ->orderByRank();
    }
}
