<?php

namespace Pixel\BlockBundle;

use Nijens\ProtocolStream\Stream\Stream;
use Nijens\ProtocolStream\StreamManager;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class BlockBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $rootDirectory = $container->getParameter('kernel.project_dir');
        $this->registerStream($rootDirectory);
    }

    public function boot(): void
    {
        $rootDirectory = $this->container->get('kernel')->getProjectDir();
        $this->registerStream($rootDirectory);
        $this->container->get('twig')->getLoader()->addPath($this->getPath() . '/Resources/views', 'sulu-block-bundle');

        parent::boot();
    }

    /**
     * Register the stream for the given $rootDirectory.
     *
     * @param string $rootDirectory
     */
    private function registerStream($rootDirectory): void
    {
        $streamManager = new StreamManager();
        if (is_null($streamManager->getStream('sulu-block-bundle'))) {
            $stream = new Stream('sulu-block-bundle', [
                'blocks' => __DIR__ . '/Resources/templates/blocks/',
                'forms' => __DIR__ . '/Resources/forms/',
                'properties' => __DIR__ . '/Resources/templates/properties/',
                'app-properties' => $rootDirectory . '/config/templates/PixelSuluBlockBundle/properties/',
                'app-property-params' => $rootDirectory . '/config/templates/PixelSuluBlockBundle/params/',
            ]);

            StreamManager::create()->registerStream($stream);
        }
    }
}
