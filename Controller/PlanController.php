<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Controller;

use Dzangocart\Bundle\SubscriptionBundle\Form\Type\PlanFeaturesFormType;
use Dzangocart\Bundle\SubscriptionBundle\Form\Type\PlanFormType;
use Dzangocart\Bundle\SubscriptionBundle\Form\Type\PlanPricesFormType;
use Dzangocart\Bundle\SubscriptionBundle\Propel\Plan;
use Dzangocart\Bundle\SubscriptionBundle\Propel\PlanQuery;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PlanController extends Controller
{
    protected $container;

    public function __construct(ContainerInterface $container = null)
    {
        $this->container = $container;
    }
    /**
     * Lists all Plans.
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
     * @Template()
     */
    public function deleteAction(Request $request, $id)
    {
        $plan = $this->getPlan($id);

        $plan->delete();

        $this->get('session')->getFlashBag()->add(
            'success',
            $plan->getName() . " " . $this->get('translator')->trans(
                'plan.delete.success',
                array(),
                'dzangocart_subscription',
                $request->getLocale()
            )
        );

        return $this->redirect($this->generateUrl('dzangocart_subscription_plans'));
    }

    /**
     * Create a Plan entity.
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
     * @Template("DzangocartSubscriptionBundle:Plan:features.html.twig")
     */
    public function featuresAction(Request $request, $id)
    {
        $plan = $this->getPlan($id);

        $form = $this->createForm(
            new PlanFeaturesFormType($request->getLocale()),
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
     * @Template("DzangocartSubscriptionBundle:Plan:prices.html.twig")
     */
    public function pricesAction(Request $request, $id)
    {
        $plan = $this->getPlan($id);

        $form = $this->createForm(
            new PlanPricesFormType($request->getLocale()),
            $plan,
            array(
                'action' => $this->generateUrl('dzangocart_subscription_plan_prices', array('id' => $id))
            )
        );

        $form->handleRequest($request);

        if ($form->isValid()) {
            $plan->save();
            $this->get('session')->getFlashBag()->add(
                'plan.prices',
                $this->get('translator')->trans('plan.prices.success', array(), 'dzangocart_subscription', $request->getLocale())
            );
        }

        return array(
            'plan' => $plan,
            'form' => $form->createView()
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
