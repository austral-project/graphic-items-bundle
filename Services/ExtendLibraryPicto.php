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

use Austral\GraphicItemsBundle\Model\Picto;
use Austral\ToolsBundle\AustralTools;
use Austral\ToolsBundle\Services\Debug;
use Symfony\Component\DependencyInjection\ContainerInterface;
use function Symfony\Component\String\u;

class ExtendLibraryPicto
{

  /**
   * @var string
   */
  protected string $libraryKey;

  /**
   * @var string
   */
  protected string $extendLibraryPath;

  /**
   * @var string
   */
  protected string $extendLibraryDataPath;

  /**
   * @var string
   */
  protected string $iconsPath;

  /**
   * @var array
   */
  protected array $icons = array();

  /**
   * @var bool
   */
  protected bool $isInitialise = false;

  /**
   * @var Debug
   */
  protected Debug $debug;

  /**
   * ExtendLibraryPicto constructor
   *
   * @param string $libraryKey
   * @param array $libraryConfig
   * @param ContainerInterface $container
   * @param Debug $debug
   */
  public function __construct(string $libraryKey, array $libraryConfig, ContainerInterface $container, Debug $debug)
  {
    $this->libraryKey = $libraryKey;
    $this->iconsPath = AustralTools::join($container->getParameter("kernel.project_dir"), $libraryConfig["path"]);
    $this->debug = $debug;
  }

  /**
   * init
   *
   * @param $force
   *
   * @return $this
   * @throws \Exception
   */
  public function init($force = false): ExtendLibraryPicto
  {
    $this->debug->stopWatchStart("austral.extendLibraryPicto.{$this->libraryKey}.init", "austral.graphic_items");
    if(!$this->isInitialise || $force)
    {
      if(file_exists($this->iconsPath))
      {
        foreach (scandir($this->iconsPath) as $filename)
        {
          if(str_ends_with($filename, ".svg"))
          {
            $filePath = AustralTools::join($this->iconsPath, $filename);
            $fileContent = file_get_contents($filePath);
            $keyname = preg_replace("/\.svg$/", "", $filename);
            preg_match("/<svg .* viewBox=\"([\d]{0,2} [\d]{0,2} [\d]{0,2} [\d]{0,2})\".*>/", $fileContent, $matches);
            $keynamePicto = "{$this->libraryKey}-{$keyname}";
            $this->icons[$keynamePicto] = Picto::create($keynamePicto)
              ->setCategory("{$this->libraryKey}-picto")
              ->setTitle(u($keyname)->replace("-", " ")->title()->toString())
              ->setKeynameReal($keyname)
              ->setPath($filePath)
              ->setIsSVG(true)
              ->setViewBox(AustralTools::getValueByKey($matches, 1, null))
              ->setContent($fileContent);
          }
        }
      }
      $this->isInitialise = true;
    }
    $this->debug->stopWatchStop("austral.extendLibraryPicto.{$this->libraryKey}.init");
    return $this;
  }

  /**
   * getLibraryKey
   *
   * @return string
   */
  public function getLibraryKey(): string
  {
    return $this->libraryKey;
  }

  /**
   * generateKeyname
   *
   * @param string $string
   * @param bool $removeDot
   *
   * @return string
   */
  protected function generateKeyname(string $string, bool $removeDot = false): string
  {
    $keyname = rtrim($string, ".");
    if($removeDot)
    {
      $keyname = str_replace('.', '', $keyname);
    }
    else
    {
      $keyname = str_replace('.', 'dot', $keyname);
    }
    $keyname = str_replace(array("&", "-", " ", "+"), array("and", "", "", "plus"), $keyname);
    return u($keyname)->camel()->lower()->ascii()->toString();
  }

  /**
   * getIcons
   * @return array
   */
  public function getPictos(): array
  {
    return $this->icons;
  }

  /**
   * getPicto
   *
   * @param string $keyname
   *
   * @return Picto|null
   */
  public function getPicto(string $keyname): ?Picto
  {
    return AustralTools::getValueByKey($this->getPictos(), $keyname, null);
  }


}