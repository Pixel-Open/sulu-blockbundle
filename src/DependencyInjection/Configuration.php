<?php

declare(strict_types=1);

namespace Pixel\BlockBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Configuration class for the BlockBundle.
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generate the configuration tree builder.
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        return new TreeBuilder('pixel_blockbundle');
    }
}
