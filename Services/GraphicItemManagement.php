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
use Symfony\Component\DependencyInjection\ContainerInterface;

class GraphicItemManagement
{

  /**
   * @var SimpleIcon
   */
  protected SimpleIcon $simpleIcon;

  protected AustralFontIcon $australFontIcon;

  /**
   * GraphicItemManagement constructor
   *
   * @param ContainerInterface $container
   * @param SimpleIcon $simpleIcon
   * @param AustralFontIcon $australFontIcon
   */
  public function __construct(ContainerInterface $container, SimpleIcon $simpleIcon, AustralFontIcon $australFontIcon)
  {
    $this->simpleIcon = $simpleIcon;
    $this->australFontIcon = $australFontIcon;
  }

  /**
   * getIcons
   * @return array
   */
  public function getIcons(): array
  {
    return array(
      "austral-picto" =>  $this->australFontIcon->getIcons(),
      "simple-icon"   =>  $this->simpleIcon->getIcons(),
    );
  }

  /**
   * getIcon
   *
   * @param string $keyname
   *
   * @return Icon|null
   */
  public function getIcon(string $keyname): ?Icon
  {
    $icon = null;
    if(str_contains($keyname, "austral-picto"))
    {
      $keyname = str_replace("austral-picto-", "", $keyname);
      /** @var Icon $picto */
      $icon = $this->australFontIcon->getIcon($keyname);
    }
    if(str_contains($keyname, "simple-icon"))
    {
      $keyname = str_replace("simple-icon-", "", $keyname);
      /** @var Icon $picto */
      $icon = $this->simpleIcon->getIcon($keyname);
    }
    return $icon;
  }

}