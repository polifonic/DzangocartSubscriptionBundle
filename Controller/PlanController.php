<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Controller;

use Dzangocart\Bundle\SubscriptionBundle\Propel\Plan;
use Dzangocart\Bundle\SubscriptionBundle\Propel\PlanFeature;
use Dzangocart\Bundle\SubscriptionBundle\Propel\PlanFeatureDefinitionQuery;
use Dzangocart\Bundle\SubscriptionBundle\Form\Type\PlanFormType;
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

            $all_feature_count = $this->getPlanFeatureDefinitionQuery()
                ->count();
            $entity_feature_count = $plan->getPlanFeatures()
                ->count();

            for ($i = 1; $i <= $all_feature_count - $entity_feature_count; $i++) {
                $entity->addPlanFeature(new PlanFeature());
            }

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


            // TODO [OP 2014-06-07] Add flash success message
            return $this->redirect($this->generateUrl('dzangocart_subscription_plans'));
        }

        return array(
            'form' => $form->createView(),
            'plan' => $plan
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

    protected function getQuery()
    {
        return PlanQuery::create()
                ->joinWithI18n($this->getRequest()->getLocale())
                ->orderByRank();
    }

    protected function getPlan($id) {
        $plan = $this->getQuery()
            ->findPk($id);

        if (!$plan) {
            throw new NotFoundHttpException('Plan not found');
        }

        return $plan;
    }

    protected function getPlanFeatureDefinitionQuery()
    {
        return PlanFeatureDefinitionQuery::create();
    }
}
