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

use DateTimeInterface;
use Sylius\Component\Core\Model\ShipmentInterface;
use Sylius\Component\Resource\Model\TimestampableTrait;
use DateTime;
use DateInterval;

class Slot implements SlotInterface
{
    use TimestampableTrait;

    private ?int $id = null;
    private ?DateTimeInterface $timestamp = null;
    private ?int $preparationDelay = null;
    private ?int $pickupDelay = null;
    private ?int $durationRange = null;
    private ?ShipmentInterface $shipment = null;

    /**
     * {@inheritDoc}
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     */
    public function getTimestamp(): ?DateTimeInterface
    {
        return $this->timestamp;
    }

    /**
     * {@inheritdoc}
     */
    public function setTimestamp(?DateTimeInterface $timetamp): void
    {
        $this->timestamp = $timetamp;
    }

    /**
     * {@inheritdoc}
     */
    public function getPreparationDelay(): ?int
    {
        return $this->preparationDelay;
    }

    /**
     * {@inheritdoc}
     */
    public function setPreparationDelay(?int $preparationDelay): void
    {
        $this->preparationDelay = $preparationDelay;
    }

    /**
     * {@inheritdoc}
     */
    public function getPickupDelay(): ?int
    {
        return $this->pickupDelay;
    }

    /**
     * {@inheritdoc}
     */
    public function setPickupDelay(?int $pickupDelay): void
    {
        $this->pickupDelay = $pickupDelay;
    }

    /**
     * {@inheritdoc}
     */
    public function getDurationRange(): ?int
    {
        return $this->durationRange;
    }

    /**
     * {@inheritdoc}
     */
    public function setDurationRange(?int $durationRange): void
    {
        $this->durationRange = $durationRange;
    }

    /**
     * {@inheritdoc}
     */
    public function getShipment(): ?ShipmentInterface
    {
        return $this->shipment;
    }

    /**
     * {@inheritdoc}
     */
    public function setShipment(?ShipmentInterface $shipment): void
    {
        $this->shipment = $shipment;
    }

    /**
     * {@inheritDoc}
     */
    public function getSlotDelay(): int
    {
        return
            (int) $this->getPreparationDelay() > (int) $this->getPickupDelay() ?
            (int) $this->getPreparationDelay() : (int) $this->getPickupDelay();
    }

    /**
     * {@inheritDoc}
     */
    public function isValid(): bool
    {
        $minDate = new DateTime();
        $minDate->add(new DateInterval(sprintf('PT%dM', $this->getSlotDelay()))); // Add minutes delay

        // Too late the slot is not valid anymore
        if ($this->getTimestamp() < $minDate) {
            return false;
        }

        return true;
    }
}
