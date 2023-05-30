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

class GraphicItemManagement
{

  /**
   * @var SimpleIcon
   */
  protected SimpleIcon $simpleIcon;

  /**
   * @var AustralFontIcon
   */
  protected AustralFontIcon $australFontIcon;

  /**
   * @var LocalIcon
   */
  protected LocalIcon $localIcon;

  /**
   * GraphicItemManagement constructor
   *
   * @param SimpleIcon $simpleIcon
   * @param AustralFontIcon $australFontIcon
   * @param LocalIcon $localIcon
   */
  public function __construct(SimpleIcon $simpleIcon, AustralFontIcon $australFontIcon, LocalIcon $localIcon)
  {
    $this->simpleIcon = $simpleIcon;
    $this->australFontIcon = $australFontIcon;
    $this->localIcon = $localIcon;
  }

  /**
   * getIcons
   * @return array
   */
  public function getIcons(): array
  {
    return array(
      "austral-icon"  =>  $this->australFontIcon->getIcons(),
      "simple-icon"   =>  $this->simpleIcon->getIcons(),
      "local-icon"    =>  $this->localIcon->getIcons(),
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
    if(str_contains($keyname, "austral-icon"))
    {
      $keyname = str_replace("austral-icon-", "", $keyname);
      /** @var Icon $picto */
      $icon = $this->australFontIcon->getIcon($keyname);
    }
    if(str_contains($keyname, "simple-icon"))
    {
      $keyname = str_replace("simple-icon-", "", $keyname);
      /** @var Icon $picto */
      $icon = $this->simpleIcon->getIcon($keyname);
    }
    if(str_contains($keyname, "local-icon"))
    {
      $keyname = str_replace("local-icon-", "", $keyname);
      /** @var Icon $picto */
      $icon = $this->localIcon->getIcon($keyname);
    }
    return $icon;
  }

  /**
   * spriteSVG
   * @return SpriteSVG
   * @throws \DOMException
   */
  public function spriteSVG(): SpriteSVG
  {
    $sprite = new SpriteSVG();
    $i = 0;
    foreach ($this->getIcons() as $type => $iconsByType)
    {
      if($type !== "local-icon")
      {
        /** @var Icon $icon */
        foreach ($iconsByType as $icon)
        {
          $sprite->addAllStates("{$type}-{$icon->getKeyname()}", $icon->getPath(), $i);
          $i++;
        }
      }
    }
    return $sprite;
  }

}