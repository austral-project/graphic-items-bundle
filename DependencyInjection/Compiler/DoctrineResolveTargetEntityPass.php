<?php
/*
 * This file is part of the Austral GraphicItems Bundle package.
 *
 * (c) Austral <support@austral.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Austral\GraphicItemsBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Austral GraphicItems Load Doctrine Resolve.
 * @author Matthieu Beurel <matthieu@austral.dev>
 * @final
 */
class DoctrineResolveTargetEntityPass implements CompilerPassInterface
{
  /**
   * {@inheritdoc}
   */
  public function process(ContainerBuilder $container)
  {
    $definition = $container->findDefinition('doctrine.orm.listeners.resolve_target_entity');
    $resolveTargetEntities = $container->getParameter("austral.resolve_target_entities.graphic_items");
    foreach($resolveTargetEntities as $from => $to)
    {
      $definition->addMethodCall('addResolveTargetEntity', array($from, $to, array(),));
    }
  }
}