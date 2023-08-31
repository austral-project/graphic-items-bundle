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
use Austral\ToolsBundle\Services\Debug;

class GraphicItemManagement
{

  /**
   * @var SimpleIcon
   */
  protected SimpleIcon $simpleIcon;

  /**
   * @var AustralPicto
   */
  protected AustralPicto $australPicto;

  /**
   * @var CustomPicto
   */
  protected CustomPicto $customPicto;

  /**
   * @var Debug
   */
  protected Debug $debug;

  /**
   * GraphicItemManagement constructor
   *
   * @param SimpleIcon $simpleIcon
   * @param AustralPicto $australPicto
   * @param CustomPicto $customPicto
   * @param Debug $debug
   */
  public function __construct(SimpleIcon $simpleIcon, AustralPicto $australPicto, CustomPicto $customPicto, Debug $debug)
  {
    $this->simpleIcon = $simpleIcon;
    $this->australPicto = $australPicto;
    $this->customPicto = $customPicto;
    $this->debug = $debug;
  }

  /**
   * init
   * @return $this
   * @throws \Exception
   */
  public function init(): GraphicItemManagement
  {
    $this->debug->stopWatchStart("austral.graphicItemManagement.init", "austral.graphic_items");
    $this->simpleIcon->init();
    $this->australPicto->init();
    $this->customPicto->init();
    $this->debug->stopWatchStop("austral.graphicItemManagement.init");
    return $this;
  }

  /**
   * getPictos
   *
   * @param bool $withCateg
   *
   * @return array
   * @throws \Exception
   */
  public function getPictos(bool $withCateg = false): array
  {
    if($withCateg)
    {
      $pictos = array(
        "austral-picto"   =>  array(
          "pictos"  =>  $this->australPicto->getPictos()
        ),
        "simple-icon"     =>  array(
          "pictos"  =>  $this->simpleIcon->getPictos()
        ),
      );
      foreach ($this->customPicto->getPictosByCateg() as $categId => $values)
      {
        $pictos[$categId] = $values;
      }
    }
    else
    {
      $pictos = array(
        "austral-picto"   =>  $this->australPicto->getPictos(),
        "simple-icon"     =>  $this->simpleIcon->getPictos(),
        "custom-picto"    =>  $this->customPicto->getPictos()
      );
    }
    return $pictos;
  }

  /**
   * getPicto
   *
   * @param string $keyname
   *
   * @return Picto|null
   * @throws \Exception
   */
  public function getPicto(string $keyname): ?Picto
  {
    $icon = null;
    if(str_contains($keyname, "austral-picto"))
    {
      /** @var Picto $picto */
      $icon = $this->australPicto->getPicto($keyname);
    }
    elseif(str_contains($keyname, "simple-icon"))
    {
      /** @var Picto $picto */
      $icon = $this->simpleIcon->getPicto($keyname);
    }
    elseif(str_contains($keyname, "custom-picto"))
    {
      /** @var Picto $picto */
      $icon = $this->customPicto->getPicto($keyname);
    }
    return $icon;
  }

  /**
   * spriteSVG
   * @return SpriteSVG
   * @throws \DOMException
   * @throws \Exception
   */
  public function spriteSVG(): SpriteSVG
  {
    $this->simpleIcon->init();
    $this->australPicto->init();
    $sprite = new SpriteSVG();
    $i = 0;
    foreach ($this->getPictos() as $type => $iconsByType)
    {
      if($type !== "custom-picto")
      {
        /** @var Picto $icon */
        foreach ($iconsByType as $icon)
        {
          $sprite->addAllStates("{$icon->getKeyname()}", $icon->getPath(), $i);
          $i++;
        }
      }
    }
    return $sprite;
  }

}