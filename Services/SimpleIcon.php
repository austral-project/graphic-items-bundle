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

class SimpleIcon
{

  /**
   * @var string
   */
  protected string $simpleIconsPath;

  /**
   * @var string
   */
  protected string $simpleIconsDataPath;

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
   * SimpleIcon constructor
   *
   * @param ContainerInterface $container
   * @param Debug $debug
   */
  public function __construct(ContainerInterface $container, Debug $debug)
  {
    $this->simpleIconsPath = "{$container->getParameter("kernel.project_dir")}/vendor/simple-icons/simple-icons";
    $this->simpleIconsDataPath = "{$this->simpleIconsPath}/_data/simple-icons.json";
    $this->iconsPath = "{$this->simpleIconsPath}/icons";
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
  public function init($force = false): SimpleIcon
  {
    $this->debug->stopWatchStart("austral.simplePicto.init", "austral.graphic_items");
    if(!$this->isInitialise || $force)
    {
      $iconsNoFiles = array();
      if(file_exists($this->simpleIconsDataPath))
      {
        $simpleIcons = json_decode(file_get_contents($this->simpleIconsDataPath));
        foreach ($simpleIcons->icons as $icon)
        {
          $keyname = $this->generateKeyname($icon->title);
          $filePath = "{$this->iconsPath}/{$keyname}.svg";
          if(!file_exists($filePath))
          {
            $keyname = $this->generateKeyname($icon->title, true);
            $filePath = "{$this->iconsPath}/{$keyname}.svg";
          }
          if(file_exists($filePath))
          {
            $fileContent = file_get_contents($filePath);
            preg_match("/<svg .* viewBox=\"([\d]{0,2} [\d]{0,2} [\d]{0,2} [\d]{0,2})\".*>/", $fileContent, $matches);
            $keyname = "simple-icon-{$keyname}";
            $this->icons[$keyname] = Picto::create($keyname)
              ->setTitle($icon->title)
              ->setHexa($icon->hex)
              ->setPath($filePath)
              ->setIsSVG(true)
              ->setViewBox(AustralTools::getValueByKey($matches, 1, null))
              ->setContent($fileContent);
          }
          else
          {
            $iconsNoFiles[$keyname] = $icon;
          }
        }
      }
      $this->isInitialise = true;
    }
    $this->debug->stopWatchStop("austral.simplePicto.init");
    return $this;
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