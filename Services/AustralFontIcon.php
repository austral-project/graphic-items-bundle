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

use Austral\GraphicItemsBundle\Model\Icon;
use Austral\ToolsBundle\AustralTools;
use Symfony\Component\DependencyInjection\ContainerInterface;

class AustralFontIcon
{

  /**
   * @var string
   */
  protected string $iconsPath;

  /**
   * @var array
   */
  protected array $icons = array();

  /**
   * SimpleIcon constructor
   *
   * @param ContainerInterface $container
   */
  public function __construct(ContainerInterface $container)
  {
    $australFontsIconsPath = "{$container->getParameter("kernel.project_dir")}/vendor/austral/design-bundle";
    $AustralFontIconsDataPath = "{$australFontsIconsPath}/Resources/assets/styles/fonts/austral-picto/selection.json";
    $this->iconsPath = "{$australFontsIconsPath}/Resources/public/austral-picto";

    if(file_exists($AustralFontIconsDataPath))
    {
      $fontIcons = json_decode(file_get_contents($AustralFontIconsDataPath));
      foreach ($fontIcons->icons as $icon)
      {
        $keyname = $icon->properties->name;
        $filePath = "{$this->iconsPath}/{$keyname}.svg";
        if(file_exists($filePath))
        {
          $fileContent = file_get_contents($filePath);
          preg_match("/<svg .* viewBox=\"([\d]{0,2} [\d]{0,2} [\d]{0,2} [\d]{0,2})\".*>/", $fileContent, $matches);
          $this->icons[$keyname] = Icon::create($keyname)
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
  }

  /**
   * getSimpleIcons
   * @return array
   */
  public function getIcons(): array
  {
    return $this->icons;
  }

  /**
   * getSimpleIcon
   *
   * @param string $keyname
   *
   * @return Icon|null
   */
  public function getIcon(string $keyname): ?Icon
  {
    return AustralTools::getValueByKey($this->getIcons(), $keyname, null);
  }


}