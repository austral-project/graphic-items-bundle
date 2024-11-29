<?php
/*
 * This file is part of the App package.
 *
 * (c) Yipikai <support@yipikai.studio>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Austral\GraphicItemsBundle\Services;

use Austral\GraphicItemsBundle\Configuration\GraphicItemsConfiguration;
use Austral\ToolsBundle\AustralTools;
use Austral\ToolsBundle\Services\Debug;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ExtendLibrariesPicto
{

  protected array $extendLibraryPictos = array();

  /**
   * @var Debug
   */
  protected Debug $debug;

  /**
   * SimpleIcon constructor
   *
   * @param ContainerInterface $container
   * @param GraphicItemsConfiguration $graphicItemsConfiguration
   * @param Debug $debug
   */
  public function __construct(ContainerInterface $container, GraphicItemsConfiguration $graphicItemsConfiguration, Debug $debug)
  {
    foreach ($graphicItemsConfiguration->get("extend_libraries_picto") as $libraryKey => $libraryConfig)
    {
      $this->extendLibraryPictos[$libraryKey] = new ExtendLibraryPicto($libraryKey, $libraryConfig, $container, $debug);
    }
    $this->debug = $debug;
  }

  /**
   * init
   *
   * @param bool $force
   *
   * @return ExtendLibrariesPicto
   * @throws \Exception
   */
  public function init($force = false): ExtendLibrariesPicto
  {
    $this->debug->stopWatchStart("austral.extendLibraryPicto.init", "austral.graphic_items");
    /** @var ExtendLibraryPicto $extendLibraryPicto */
    foreach ($this->extendLibraryPictos as $extendLibraryPicto)
    {
      $extendLibraryPicto->init($force);
    }
    $this->debug->stopWatchStop("austral.extendLibraryPicto.init");
    return $this;
  }

  /**
   * getLibrariesPicto
   *
   * @return array
   */
  public function getLibrariesPicto(): array
  {
    return $this->extendLibraryPictos;
  }

  /**
   * getLibraryPicto
   *
   * @param string $libraryName
   * @return ExtendLibraryPicto|null
   */
  public function getLibraryPicto(string $libraryName): ?ExtendLibraryPicto
  {
    return AustralTools::getValueByKey($this->extendLibraryPictos, $libraryName, null);
  }

}