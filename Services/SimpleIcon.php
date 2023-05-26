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
use function Symfony\Component\String\u;

class SimpleIcon
{

  protected string $iconsPath;

  /**
   * @var array
   */
  protected array $simpleIcons = array();

  /**
   * SimpleIcon constructor
   *
   * @param ContainerInterface $container
   */
  public function __construct(ContainerInterface $container)
  {
    $simpleIconsPath = "{$container->getParameter("kernel.project_dir")}/vendor/simple-icons/simple-icons";
    $simpleIconsDataPath = "{$simpleIconsPath}/_data/simple-icons.json";
    $this->iconsPath = "{$simpleIconsPath}/icons";
    $iconsNoFiles = array();
    if(file_exists($simpleIconsDataPath))
    {
      $simpleIcons = json_decode(file_get_contents($simpleIconsDataPath));
      foreach ($simpleIcons->icons as $icon)
      {
        $keyname = $this->generateKeyname($icon->title);
        if(!file_exists("{$this->iconsPath}/{$keyname}.svg"))
        {
          $keyname = $this->generateKeyname($icon->title, true);
        }
        if(file_exists("{$this->iconsPath}/{$keyname}.svg"))
        {
          $this->simpleIcons[$keyname] = Icon::create($keyname)
            ->setTitle($icon->title)
            ->setHexa($icon->hex)
            ->setPath("{$this->iconsPath}/{$keyname}.svg")
            ->setSource($icon->source);
        }
        else
        {
          $iconsNoFiles[$keyname] = $icon;
        }
      }
    }
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
   * getSimpleIcons
   * @return array
   */
  public function getSimpleIcons(): array
  {
    return $this->simpleIcons;
  }

  /**
   * getSimpleIcon
   *
   * @param string $keyname
   *
   * @return Icon|null
   */
  public function getSimpleIcon(string $keyname): ?Icon
  {
    return AustralTools::getValueByKey($this->getSimpleIcons(), $keyname, null);
  }



}