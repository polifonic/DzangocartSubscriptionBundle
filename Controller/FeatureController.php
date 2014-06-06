<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Controller;

use Dzangocart\Bundle\SubscriptionBundle\Form\Type\PlanFeatureDefinitionFormType;
use Dzangocart\Bundle\SubscriptionBundle\Propel\PlanFeatureDefinition;
use Dzangocart\Bundle\SubscriptionBundle\Propel\PlanFeatureDefinitionQuery;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/feature")
 * @Template
 */
class FeatureController extends Controller
{
    /**
     *
     * @Route("/", name="dzangocart_subscription_features")
     * @Template("DzangocartSubscriptionBundle:Feature:index.html.twig")
     */
    public function indexAction(Request $request)
    {
        $features = $this->getQuery()
            ->find();

        return array('features' => $features);
    }

    /**
     * 
     * @Route("/{id}/edit", name="dzangocart_subscription_feature_edit")
     * @Template("DzangocartSubscriptionBundle:Feature:edit.html.twig")
     */
    public function editAction($id, Request $request)
    {
        $feature = $this->getQuery()
            ->findPk($id);

        if ($feature) {
            $form = $this->createForm(
                new PlanFeatureDefinitionFormType(),
                $feature,
                array(
                    'action' => $this->generateUrl('dzangocart_subscription_feature_edit', array('id' => $id))
                )
            );

            $form->handleRequest($request);

            if ($form->isValid()) {
                $feature->save();
                return $this->redirect($this->generateUrl('dzangocart_subscription_features'));
            }

            return array(
                'form' => $form->createView(),
                'feature' => $feature
            );
        } else {
            return $this->redirect($this->generateUrl('dzangocart_subscription_features'));
        }

    }

    /**
     * Delete existing Feature entity.
     * 
     * @Route("/{id}/delete", name="dzangocart_subscription_feature_delete")
     * @Template()
     */
    public function deleteAction($id)
    {
        $entity = $this->getQuery()
            ->findPk($id);

        if ($entity && $entity->getPlanFeatures()->isEmpty()) {
            $entity->delete(); 
        }

        return $this->redirect($this->generateUrl('dzangocart_subscription_features'));
    }

    /**
     * 
     * @Route("/create", name="dzangocart_subscription_feature_create")
     * @Template("DzangocartSubscriptionBundle:Feature:create.html.twig")
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(
            new PlanFeatureDefinitionFormType(),
            $feature = new PlanFeatureDefinition(),
            array(
                'action' => $this->generateUrl('dzangocart_subscription_feature_create')
            )
        );

        $form->handleRequest($request);

        if ($form->isValid()) {
            $feature->save();
            return $this->redirect($this->generateUrl('dzangocart_subscription_features'));
        }

        return array(
            'form' => $form->createView()
        );
    }

    protected function getQuery()
    {
        return PlanFeatureDefinitionQuery::create()
            ->joinWithI18n($this->getRequest()->getLocale())
            ->orderByRank();
    }
}
