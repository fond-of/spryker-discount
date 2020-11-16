<?php

namespace FondOfSpryker\Zed\Discount\Communication\Controller;

use Spryker\Zed\Discount\Communication\Controller\IndexController as SprykerIndexController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \FondOfSpryker\Zed\Discount\Communication\DiscountCommunicationFactory getFactory()
 */
class IndexController extends SprykerIndexController
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createAction(Request $request): array
    {
        return array_merge(
            parent::createAction($request),
            ['currentLocale' => $this->getFactory()->getLocaleFacade()->getCurrentLocale()],
        );
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editAction(Request $request): array
    {
        return array_merge(
            parent::editAction($request),
            ['currentLocale' => $this->getFactory()->getLocaleFacade()->getCurrentLocale()],
        );
    }
}
