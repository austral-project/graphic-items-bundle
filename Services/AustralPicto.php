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

class AustralPicto
{

  /**
   * @var Debug
   */
  protected Debug $debug;

  /**
   * @var string
   */
  protected string $australFontsPictosPath;

  /**
   * @var string
   */
  protected string $australFontPictosDataPath;

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
   * SimplePicto constructor
   *
   * @param ContainerInterface $container
   * @param Debug $debug
   */
  public function __construct(ContainerInterface $container, Debug $debug)
  {
    $this->australFontsPictosPath = "{$container->getParameter("kernel.project_dir")}/vendor/austral/design-bundle";
    $this->australFontPictosDataPath = "{$this->australFontsPictosPath}/Resources/assets/styles/fonts/austral-picto/selection.json";
    $this->iconsPath = "{$this->australFontsPictosPath}/Resources/public/austral-picto";
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
  public function init($force = false): AustralPicto
  {
    $this->debug->stopWatchStart("austral.australPicto.init", "austral.graphic_items");
    if(!$this->isInitialise || $force)
    {
      if(file_exists($this->australFontPictosDataPath))
      {
        $fontPictos = json_decode(file_get_contents($this->australFontPictosDataPath));
        foreach ($fontPictos->icons as $icon)
        {
          $keyname = $icon->properties->name;
          $filePath = "{$this->iconsPath}/{$keyname}.svg";
          if(file_exists($filePath))
          {
            $keyname = "austral-picto-{$keyname}";
            $fileContent = file_get_contents($filePath);
            preg_match("/<svg .* viewBox=\"([\d]{0,2} [\d]{0,2} [\d]{0,2} [\d]{0,2})\".*>/", $fileContent, $matches);
            $this->icons[$keyname] = Picto::create($keyname)
              ->setTitle($icon->properties->name)
              ->setPath($filePath)
              ->setSvgPath($icon->icon->paths)
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
    $this->debug->stopWatchStop("austral.australPicto.init");
    return $this;
  }

  /**
   * getSimplePictos
   * @return array
   */
  public function getPictos(): array
  {
    return $this->icons;
  }

  /**
   * getSimplePicto
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