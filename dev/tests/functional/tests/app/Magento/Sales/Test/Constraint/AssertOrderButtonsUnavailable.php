<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Magento\Sales\Test\Constraint;

use Magento\Sales\Test\Fixture\OrderInjectable;
use Magento\Sales\Test\Page\Adminhtml\OrderIndex;
use Magento\Sales\Test\Page\Adminhtml\SalesOrderView;
use Magento\Mtf\Constraint\AbstractConstraint;

/**
 * Class AssertOrderButtonsUnavailable
 * Assert that buttons from dataSet are not present on page
 */
class AssertOrderButtonsUnavailable extends AbstractConstraint
{
    /**
     * Assert that buttons from dataSet are not present on page
     *
     * @param OrderIndex $orderIndex
     * @param SalesOrderView $orderView
     * @param OrderInjectable $order
     * @param string $orderButtonsUnavailable
     * @return void
     */
    public function processAssert(
        OrderIndex $orderIndex,
        SalesOrderView $orderView,
        OrderInjectable $order,
        $orderButtonsUnavailable
    ) {
        $orderIndex->open();
        $orderIndex->getSalesOrderGrid()->searchAndOpen(['id' => $order->getId()]);
        $buttons = explode(',', $orderButtonsUnavailable);
        $matches = [];
        foreach ($buttons as $button) {
            if ($orderView->getPageActions()->isActionButtonVisible(trim($button))) {
                $matches[] = $button;
            }
        }
        \PHPUnit_Framework_Assert::assertEmpty(
            $matches,
            'Buttons are present on order page.'
            . "\nLog:\n" . implode(";\n", $matches)
        );
    }

    /**
     * Returns a string representation of the object
     *
     * @return string
     */
    public function toString()
    {
        return 'Buttons from dataSet are not present on order page.';
    }
}
