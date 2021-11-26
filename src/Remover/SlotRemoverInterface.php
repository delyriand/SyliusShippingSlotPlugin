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

namespace MonsieurBiz\SyliusShippingSlotPlugin\Remover;

use MonsieurBiz\SyliusShippingSlotPlugin\Entity\OrderInterface;

interface SlotRemoverInterface
{
    public function removeIdleSlots(string $delay): void;

    public function removeOrderSlots(OrderInterface $order): void;
}
