<?php
/*
 * This file is part of the Austral ContentBlock Bundle package.
 *
 * (c) Austral <support@austral.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace Austral\GraphicItemsBundle\Configuration;

use Austral\ToolsBundle\Configuration\BaseConfiguration;

/**
 * Austral GraphicItem Configuration.
 * @author Matthieu Beurel <matthieu@austral.dev>
 * @final
 */
Class GraphicItemsConfiguration extends BaseConfiguration
{
  /**
   * @var int|null
   */
  protected ?int $niveauMax = 1;

  /**
   * @var string|null
   */
  protected ?string $prefix = "graphic_item";


}