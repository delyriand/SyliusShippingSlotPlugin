<?php

/*
 * This file is part of Monsieur Biz' Shipping Slot plugin for Sylius.
 *
 * (c) Monsieur Biz <sylius@monsieurbiz.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace MonsieurBiz\SyliusShippingSlotPlugin\Entity;

use Sylius\Component\Core\Model\ShipmentInterface as SyliusShipmentInterface;

interface ShipmentInterface extends SyliusShipmentInterface
{
    public function getSlot(): ?SlotInterface;

    public function setSlot(?SlotInterface $slot): void;
}
