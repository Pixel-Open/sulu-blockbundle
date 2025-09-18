<?php

declare(strict_types=1);

namespace Pixel\BlockBundle\DependencyInjection;

use Sulu\Bundle\PersistenceBundle\DependencyInjection\PersistenceExtensionTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

/**
 * Extension for the BlockBundle that configures Sulu admin forms.
 */
class BlockExtension extends Extension implements PrependExtensionInterface
{
    use PersistenceExtensionTrait;

    private const SULU_ADMIN_EXTENSION_NAME = 'sulu_admin';

    private const FORMS_DIRECTORY_PATH = __DIR__ . '/../Resources/forms';

    public function prepend(ContainerBuilder $container): void
    {
        if ($container->hasExtension(self::SULU_ADMIN_EXTENSION_NAME)) {
            $formsConfiguration = [
                'forms' => [
                    'directories' => [
                        self::FORMS_DIRECTORY_PATH,
                    ],
                ],
            ];

            $container->prependExtensionConfig(
                self::SULU_ADMIN_EXTENSION_NAME,
                $formsConfiguration
            );
        }
    }

    /**
     * Load configuration for the bundle.
     *
     * @param array<string, mixed> $configs
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $this->processConfiguration($configuration, $configs);
    }
}
