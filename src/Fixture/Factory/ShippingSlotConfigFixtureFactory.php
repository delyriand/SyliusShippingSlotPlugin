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

namespace MonsieurBiz\SyliusShippingSlotPlugin\Fixture\Factory;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\Options;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Bundle\CoreBundle\Fixture\OptionsResolver\LazyOption;
use Sylius\Bundle\CoreBundle\Fixture\Factory\ExampleFactoryInterface;
use Sylius\Bundle\CoreBundle\Fixture\Factory\AbstractExampleFactory;
use MonsieurBiz\SyliusShippingSlotPlugin\Entity\ShippingSlotConfigInterface;
use MonsieurBiz\SyliusShippingSlotPlugin\Entity\ShippingMethodInterface;
use Faker\Generator;
use Faker\Factory;

class ShippingSlotConfigFixtureFactory extends AbstractExampleFactory implements ExampleFactoryInterface
{
    private FactoryInterface $shippingSlotConfigFactory;
    private OptionsResolver $optionsResolver;
    private Generator $faker;

    /**
     * ShippingSlotConfigFixtureFactory constructor.
     *
     * @param FactoryInterface $shippingSlotConfigFactory
     */
    public function __construct(
        FactoryInterface $shippingSlotConfigFactory,
        RepositoryInterface $shippingMethodRepository
    ) {
        $this->shippingSlotConfigFactory = $shippingSlotConfigFactory;
        $this->shippingMethodRepository = $shippingMethodRepository;
        $this->faker = Factory::create();
        $this->optionsResolver = new OptionsResolver();
        $this->configureOptions($this->optionsResolver);
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $options = []): ShippingSlotConfigInterface
    {
        $options = $this->optionsResolver->resolve($options);

        /** @var ShippingSlotConfigInterface $shippingSlotConfig */
        $shippingSlotConfig = $this->shippingSlotConfigFactory->createNew();
        $shippingSlotConfig->setName($options['name']);
        $shippingSlotConfig->setRrules($options['rrules']);
        $shippingSlotConfig->setPreparationDelay($options['preparationDelay']);
        $shippingSlotConfig->setPickupDelay($options['pickupDelay']);
        $shippingSlotConfig->setDurationRange($options['durationRange']);
        $shippingSlotConfig->setAvailableSpots($options['availableSpots']);
        $shippingSlotConfig->setColor($options['color']);

        /** @var ShippingMethodInterface $shippingMethod */
        foreach ($options['shipping_methods'] as $shippingMethod) {
            $shippingMethod->setShippingSlotConfig($shippingSlotConfig);
        }

        return $shippingSlotConfig;
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefault('name', function(Options $options): string {
                return $this->faker->sentence(2, true);
            })
            ->setDefault('rrules', function(Options $options): array {
                return [
                    'RRULE:FREQ=HOURLY;INTERVAL=1;WKST=MO;BYDAY=MO,TU,WE,TH,FR;BYMONTH=9,10,11;BYHOUR=8,9,10,11,12,13,14,15,16,17,18;BYMINUTE=0;BYSECOND=0',
                    'RRULE:FREQ=HOURLY;INTERVAL=1;WKST=MO;BYDAY=MO,TU,WE,TH,FR;BYMONTH=9,10,11;BYHOUR=8,9,10,11,12,13,14,15,16,17,18;BYMINUTE=30;BYSECOND=0',
                ];
            })
            ->setDefault('preparationDelay', function(Options $options): int {
                return $this->faker->numberBetween(3, 12) * 10;
            })
            ->setDefault('pickupDelay', function(Options $options): int {
                return $this->faker->numberBetween(3, 12) * 10;
            })
            ->setDefault('durationRange', function(Options $options): int {
                return $this->faker->numberBetween(2, 4) * 60;
            })
            ->setDefault('availableSpots', function(Options $options): int {
                return $this->faker->numberBetween(5, 10);
            })
            ->setDefault('color', function(Options $options): string {
                return $this->faker->hexColor;
            })
            ->setDefault('shipping_methods', [])
            ->setAllowedTypes('shipping_methods', 'array')
            ->setNormalizer('shipping_methods', LazyOption::findBy($this->shippingMethodRepository, 'code'))
        ;
    }
}
