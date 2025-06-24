<?php

declare(strict_types=1);

namespace Pixel\BlockBundle;

use Nijens\ProtocolStream\Stream\Stream;
use Nijens\ProtocolStream\StreamManager;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\HttpKernel\KernelInterface;

class BlockBundle extends Bundle
{
    private const STREAM_NAME = 'sulu-block-bundle';

    public function build(ContainerBuilder $container): void
    {
        $rootDirectory = $container->getParameter('kernel.project_dir');
        if (!is_string($rootDirectory)) {
            throw new \RuntimeException('kernel.project_dir parameter must be a string');
        }

        $this->registerStream($rootDirectory);
    }

    public function boot(): void
    {
        $kernel = $this->container?->get('kernel');
        if (!$kernel instanceof KernelInterface) {
            throw new \RuntimeException('Kernel service not available');
        }

        $this->registerStream($kernel->getProjectDir());
        parent::boot();
    }

    private function registerStream(string $rootDirectory): void
    {
        $streamManager = new StreamManager();

        if ($streamManager->getStream(self::STREAM_NAME) !== null) {
            return;
        }

        $stream = new Stream(self::STREAM_NAME, [
            'blocks' => __DIR__ . '/Resources/templates/blocks/',
            'forms' => __DIR__ . '/Resources/forms/',
            'properties' => __DIR__ . '/Resources/templates/properties/',
            'app-properties' => $rootDirectory . '/config/templates/PixelSuluBlockBundle/properties/',
            'app-property-params' => $rootDirectory . '/config/templates/PixelSuluBlockBundle/params/',
        ]);

        StreamManager::create()->registerStream($stream);
    }
}