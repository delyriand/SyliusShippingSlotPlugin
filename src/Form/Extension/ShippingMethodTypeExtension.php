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

namespace MonsieurBiz\SyliusShippingSlotPlugin\Form\Extension;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractTypeExtension;
use Sylius\Bundle\ShippingBundle\Form\Type\ShippingMethodType;
use MonsieurBiz\SyliusShippingSlotPlugin\Form\Type\ShippingSlotConfigChoiceType;

class ShippingMethodTypeExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public static function getExtendedTypes(): iterable
    {
        return [ShippingMethodType::class];
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('shippingSlotConfig', ShippingSlotConfigChoiceType::class, [
                'required' => false,
                'placeholder' => 'monsieurbiz_shipping_slot.ui.no_shipping_slot_config',
                'label' => 'monsieurbiz_shipping_slot.ui.form.shipping_slot_config',
            ]);
    }
}
