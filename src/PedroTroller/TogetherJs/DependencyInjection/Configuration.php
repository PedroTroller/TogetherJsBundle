<?php

namespace PedroTroller\TogetherJs\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $builder = new TreeBuilder();
        $builder
            ->root('pedro_troller_together_js')
            ->children()
                ->scalarNode('vendor_url')
                    ->defaultValue('https://togetherjs.com/togetherjs-min.js')
                ->end()
                ->scalarNode('template')
                    ->defaultValue('PedroTrollerTogetherJsBundle::script.html.twig')
                ->end()
            ->end()
        ;

        return $builder;
    }
}
