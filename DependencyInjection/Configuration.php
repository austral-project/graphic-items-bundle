<?php
/*
 * This file is part of the Austral GraphicItems Bundle package.
 *
 * (c) Austral <support@austral.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Austral\GraphicItemsBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Austral GraphicItems Configuration.
 * @author Matthieu Beurel <matthieu@austral.dev>
 * @final
 */
class Configuration implements ConfigurationInterface
{
  /**
   * {@inheritdoc}
   */
  public function getConfigTreeBuilder(): TreeBuilder
  {
    $treeBuilder = new TreeBuilder('austral_graphic_items');

    $rootNode = $treeBuilder->getRootNode();
    $node = $rootNode->children();

    $this->buildGuidelineSize($node
      ->arrayNode('extend_libraries_picto')
      ->arrayPrototype()
    );

    return $treeBuilder;
  }


  /**
   * @param ArrayNodeDefinition $node
   *
   * @return mixed
   */
  protected function buildGuidelineSize(ArrayNodeDefinition $node)
  {
    $node = $node
      ->children()
      ->scalarNode('path')->isRequired()->cannotBeEmpty()->end()
      ->scalarNode('data_path')->end();
    return $node;
  }
}
