<?php
namespace Pixel\BlockBundle\DependencyInjection;
use Sulu\Bundle\PersistenceBundle\DependencyInjection\PersistenceExtensionTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
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
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $this->processConfiguration($configuration, $configs);
    }
}