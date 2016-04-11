<?php
namespace AppBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface {
  public function getConfigTreeBuilder() {
    $treeBuilder = new TreeBuilder();
    $rootNode = $treeBuilder->root('app');

    $rootNode
      ->children()
        ->arrayNode('pdf_export')
          ->children()
            ->scalarNode('base_url')->end()
            ->scalarNode('default_file_path')->end()
          ->end()
        ->end()
      ->end();

    return $treeBuilder;
  }
}
