<?php

/*
 * This file is part of Monsieur Biz' Shipping Slot plugin for Sylius.
 *
 * (c) Monsieur Biz <sylius@monsieurbiz.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MonsieurBiz\SyliusShippingSlotPlugin\Resolver;

use MonsieurBiz\SyliusShippingSlotPlugin\Entity\ShipmentInterface as MonsieurBizShipmentInterface;
use MonsieurBiz\SyliusShippingSlotPlugin\Entity\ShippingSlotConfigInterface;
use Sylius\Component\Core\Model\ShipmentInterface;
use Sylius\Component\Core\Model\ShippingMethodInterface;

final class ShippingSlotConfigResolver implements ShippingSlotConfigResolverInterface
{
    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function getShippingSlotConfig(?ShipmentInterface $shipment, ShippingMethodInterface $shippingMethod): ?ShippingSlotConfigInterface
    {
        if (!$shipment instanceof MonsieurBizShipmentInterface) {
            return null;
        }
        $currentShippingMethod = $this->getCurrentShippingMethod($shipment);
        if ($currentShippingMethod !== $shippingMethod) {
            return null;
        }

        return null !== $shipment->getSlot() ? $shipment->getSlot()->getShippingSlotConfig() : null;
    }

    private function getCurrentShippingMethod(?ShipmentInterface $subject): ?ShippingMethodInterface
    {
        /** @phpstan-ignore-next-line */
        return $subject->getMethod();
    }
}
