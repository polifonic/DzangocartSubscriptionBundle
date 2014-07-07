<?php

namespace Dzangocart\Bundle\SubscriptionBundle\Controller;

use Dzangocart\Bundle\SubscriptionBundle\Form\Type\FeatureFormType;
use Dzangocart\Bundle\SubscriptionBundle\Form\Type\FeaturePlansFormType;
use Dzangocart\Bundle\SubscriptionBundle\Propel\Feature;
use Dzangocart\Bundle\SubscriptionBundle\Propel\FeatureQuery;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     * @Route("/{id}", name = "dzangocart_subscription_feature", requirements={"id" = "\d+"})
     * @Template("DzangocartSubscriptionBundle:Feature:show.html.twig")
     */
    public function showAction(Request $request, $id)
    {
        $feature = $this->getFeature($id);

        return array(
            'feature' => $feature
        );
    }

    /**
     * @Route("/{id}/edit", name="dzangocart_subscription_feature_edit", requirements={"id" = "\d+"})
     * @Template("DzangocartSubscriptionBundle:Feature:edit.html.twig")
     */
    public function editAction(Request $request, $id)
    {
        $feature = $this->getFeature($id);

        $form = $this->createForm(
            new FeatureFormType(),
            $feature,
            array(
                'action' => $this->generateUrl('dzangocart_subscription_feature_edit', array('id' => $id))
            )
        );

        $form->handleRequest($request);

        if ($form->isValid()) {
            $feature->save();

            $this->get('session')->getFlashBag()->add(
                'feature.edit',
                $this->get('translator')->trans('feature.edit.success', array(), 'dzangocart_subscription', $request->getLocale())
            );
        }

        return array(
            'form' => $form->createView(),
            'feature' => $feature
        );
    }

    /**
     * Delete existing Feature entity.
     *
     * @Route("/{id}/delete", name="dzangocart_subscription_feature_delete", requirements={"id" = "\d+"})
     * @Template()
     */
    public function deleteAction(Request $request, $id)
    {
        $feature = $this->getFeature($id);

        if ($feature->getFeatures()->isEmpty()) {
            $feature->delete();
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
        $feature = new Feature();

        $feature->setLocale($request->getLocale());

        $form = $this->createForm(
            new FeatureFormType(),
            $feature,
            array(
                'action' => $this->generateUrl('dzangocart_subscription_feature_create')
            )
        );

        $form->handleRequest($request);

        if ($form->isValid()) {
            $feature->save();

            $this->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator')->trans(
                    'feature.create.success',
                    array(),
                    'dzangocart_subscription',
                    $request->getLocale()
                )
            );

            return $this->redirect($this->generateUrl('dzangocart_subscription_features'));
        }

        return array(
            'form' => $form->createView()
        );
    }

    /**
     * @Route("/{id}/plans", name="dzangocart_subscription_feature_plans", requirements={"id" = "\d+"})
     * @Template("DzangocartSubscriptionBundle:Feature:plans.html.twig")
     */
    public function plansAction(Request $request, $id)
    {
        $feature = $this->getFeature($id);

        $form = $this->createForm(
            new FeaturePlansFormType($request->getLocale()),
            $feature,
            array(
                'action' => $this->generateUrl('dzangocart_subscription_feature_plans', array('id' => $id))
            )
        );

        $form->handleRequest($request);

        if ($form->isValid()) {
            $feature ->save();

            $this->get('session')->getFlashBag()->add(
                'feature.plans',
                $this->get('translator')->trans('feature.plans.success', array(), 'dzangocart_subscription', $request->getLocale())
            );
        }

        return array(
            'form' => $form->createView()
        );
    }

    protected function getQuery()
    {
        return FeatureQuery::create()
            ->joinWithI18n($this->getRequest()->getLocale())
            ->orderByRank();
    }

    protected function getFeature($id)
    {
        $feature = $this->getQuery()
            ->findPk($id);

        if (!$feature) {
            throw new NotFoundHttpException('Feature not found');
        }

        return $feature;
    }
}
