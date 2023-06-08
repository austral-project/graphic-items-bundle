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
   * GraphicItemManagement constructor
   *
   * @param SimpleIcon $simpleIcon
   * @param AustralPicto $australPicto
   * @param CustomPicto $customPicto
   */
  public function __construct(SimpleIcon $simpleIcon, AustralPicto $australPicto, CustomPicto $customPicto)
  {
    $this->simpleIcon = $simpleIcon;
    $this->australPicto = $australPicto;
    $this->customPicto = $customPicto;
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
          "pictos"  =>  $this->australPicto->init()->getPictos()
        ),
        "simple-icon"     =>  array(
          "pictos"  =>  $this->simpleIcon->init()->getPictos()
        ),
      );
      foreach ($this->customPicto->init()->getPictosByCateg() as $categId => $values)
      {
        $pictos[$categId] = $values;
      }
    }
    else
    {
      $pictos = array(
        "austral-picto"   =>  $this->australPicto->init()->getPictos(),
        "simple-icon"     =>  $this->simpleIcon->init()->getPictos(),
        "custom-picto"    =>  $this->customPicto->init()->getPictos(false)
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
      $icon = $this->australPicto->init()->getPicto($keyname);
    }
    elseif(str_contains($keyname, "simple-icon"))
    {
      /** @var Picto $picto */
      $icon = $this->simpleIcon->init()->getPicto($keyname);
    }
    elseif(str_contains($keyname, "custom-picto"))
    {
      /** @var Picto $picto */
      $icon = $this->customPicto->init()->getPicto($keyname);
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