<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Controller;

use Dzangocart\Bundle\SubscriptionBundle\Form\Type\PlanFeaturesFormType;
use Dzangocart\Bundle\SubscriptionBundle\Form\Type\PlanFormType;
use Dzangocart\Bundle\SubscriptionBundle\Form\Type\PlanPricesFormType;
use Dzangocart\Bundle\SubscriptionBundle\Propel\Plan;
use Dzangocart\Bundle\SubscriptionBundle\Propel\PlanQuery;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @Route("/plan")
 * @Template
 */
class PlanController extends Controller
{
    //this is hard coded here to cap off the plans that are shown in the pricing page
    const PRICING_SHOW_LIMIT = 5;
    
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
     * Displays a Plan.
     *
     * @Route("/{id}", name="dzangocart_subscription_plan", requirements={"id" = "\d+"})
     * @Template("DzangocartSubscriptionBundle:Plan:show.html.twig")
     */
    public function showAction(Request $request, $id)
    {
        $plan = $this->getPlan($id);

        return array(
            'plan' => $plan
        );
    }

    /**
     * Displays a form to edit an existing Plan.
     *
     * @Route("/{id}/edit", name="dzangocart_subscription_plan_edit", requirements={"id" = "\d+"})
     * @Template("DzangocartSubscriptionBundle:Plan:edit.html.twig")
     */
    public function editAction(Request $request, $id)
    {
        $plan = $this->getPlan($id);

        $form = $this->createForm(
            new PlanFormType($request->getLocale()),
            $plan,
            array(
                'action' => $this->generateUrl('dzangocart_subscription_plan_edit', array('id' => $id))
            )
        );

        $form->handleRequest($request);

        if ($form->isValid()) {
            $plan->save();

            $this->get('session')->getFlashBag()->add(
                'plan.edit',
                $this->get('translator')->trans('plan.edit.success', array(), 'dzangocart_subscription', $request->getLocale())
            );
        }

        return array(
            'plan' => $plan,
            'form' => $form->createView()
        );
    }

    /**
     * Delete existing Plan entity.
     *
     * @Route("/{id}/delete", name="dzangocart_subscription_plan_delete", requirements={"id" = "\d+"})
     * @Template()
     */
    public function deleteAction(Request $request, $id)
    {
        $plan = $this->getPlan($id);

        $plan->delete();

        // TODO [OP 2014-06-07] Add flash success message
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
        $plan = new Plan();

        $plan->setLocale($request->getLocale());

        $form = $this->createForm(
            new PlanFormType(),
            $plan,
            array(
                'action' => $this->generateUrl('dzangocart_subscription_plan_create')
            )
        );

        $form->handleRequest($request);

        if ($form->isValid()) {
            $plan->save();
            return $this->redirect($this->generateUrl('dzangocart_subscription_plan', array('id' => $plan->getId())));
        }

        return array(
            'plan' => $plan,
            'form' => $form->createView()
        );
    }

    /**
     *
     * @Route("/{id}/disable", name="dzangocart_subscription_plan_disable", requirements={"id" = "\d+"})
     * @Template()
     */
    public function disableAction(Request $request, $id)
    {
        $plan = $this->getPlan($id);

        $plan->disable();
        
        $plan->save();
        
        return $this->redirect($this->generateUrl('dzangocart_subscription_plans'));
    }
    
    /**
     * @Route("/{id}/enable", name="dzangocart_subscription_plan_enable", requirements={"id" = "\d+"})
     * @Template()
     */
    public function enableAction(Request $request, $id)
    {
        $plan = $this->getPlan($id);

        $plan->enable();
        
        $plan->save();
        
        return $this->redirect($this->generateUrl('dzangocart_subscription_plans'));
    }

    /**
     * Displays a form to edit a Plan's features.
     *
     * @Route("/{id}/features", name="dzangocart_subscription_plan_features", requirements={"id" = "\d+"})
     * @Template("DzangocartSubscriptionBundle:Plan:features.html.twig")
     */
    public function featuresAction(Request $request, $id)
    {
        $plan = $this->getPlan($id);

        $form = $this->createForm(
            new PlanFeaturesFormType(),
            $plan,
            array(
                'action' => $this->generateUrl('dzangocart_subscription_plan_features', array('id' => $id))
            )
        );

        $form->handleRequest($request);

        if ($form->isValid()) {
            $plan->save();

            $this->get('session')->getFlashBag()->add(
                'plan.features',
                $this->get('translator')->trans('plan.features.success', array(), 'dzangocart_subscription', $request->getLocale())
            );
        }

        return array(
            'plan' => $plan,
            'features' => $plan->getFeatures(),
            'form' => $form->createView()
        );
    }

    /**
     * Displays a form to edit a Plan's prices.
     *
     * @Route("/{id}/prices", name="dzangocart_subscription_plan_prices", requirements={"id" = "\d+"})
     * @Template("DzangocartSubscriptionBundle:Plan:prices.html.twig")
     */
    public function pricesAction(Request $request, $id)
    {
        $plan = $this->getPlan($id);

        $form = $this->createForm(
            new PlanPricesFormType(),
            $plan,
            array(
                'action' => $this->generateUrl('dzangocart_subscription_plan_prices', array('id' => $id))
            )
        );

        $form->handleRequest($request);

        if ($form->isValid()) {
            $plan->save();
        }

        return array(
            'plan' => $plan,
            'form' => $form->createView()
        );
    }
    
    /**
     * @Template() 
     */
    public function pricingAction()
    {
        $col_width = 2;
        $row_width = 12;

        $plans = $this->getQuery()
            ->getActive()
            ->limit(self::PRICING_SHOW_LIMIT)
            ->find();
        
        $plans_count = count($plans);

        if ($plans_count > 0 && $plans_count < 5  ) {
            $col_width = 12 / $plans_count;
            $row_width = $plans_count * 3;
        }

        return array(
            'plans' => $plans,
            'col_width' => $col_width,
            'row_width' => $row_width
        );
    }

    protected function getQuery()
    {
        return PlanQuery::create()
                ->joinWithI18n($this->getRequest()->getLocale())
                ->orderByRank();
    }

    protected function getPlan($id)
    {
        $plan = $this->getQuery()
            ->findPk($id);

        if (!$plan) {
            throw new NotFoundHttpException('Plan not found');
        }

        return $plan;
    }
}
