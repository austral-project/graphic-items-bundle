<?php
/*
 * This file is part of the Austral GraphicItems Bundle package.
 *
 * (c) Austral <support@austral.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace Austral\GraphicItemsBundle\TwigExtension;

use Austral\GraphicItemsBundle\Services\GraphicItemManagement;
use Austral\ToolsBundle\AustralTools;
use Symfony\Component\Routing\Router;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Austral GraphicItem Twig Extension.
 * @author Matthieu Beurel <matthieu@austral.dev>
 * @final
 */
class GraphicItemTwig extends AbstractExtension
{

  /**
   * @var GraphicItemManagement
   */
  protected GraphicItemManagement $graphicItemManagement;

  /**
   * @var Router
   */
  protected Router $urlGenerator;

  /**
   * Initialize tinymce helper
   *
   * @param GraphicItemManagement $graphicItemManagement
   * @param Router $urlGenerator
   */
  public function __construct(GraphicItemManagement $graphicItemManagement, Router $urlGenerator)
  {
    $this->graphicItemManagement = $graphicItemManagement;
    $this->urlGenerator = $urlGenerator;
  }

  /**
   * @return TwigFilter[]
   */
  public function getFilters(): array
  {
    return [
      new TwigFilter('graphic_item_render', [$this, 'render']),
    ];
  }

  /**
   * @return TwigFunction[]
   */
  public function getFunctions(): array
  {
    return array(
      "graphic_item_render"              => new TwigFunction("graphic_item_render", array($this, "render")),
    );
  }


  /**
   * render
   *
   * @param string|null $keyname
   * @param array $attributes
   *
   * @return string
   * @throws \Exception
   */
  public function render(?string $keyname, array $attributes = array()): string
  {
    if($keyname && ($icon = $this->graphicItemManagement->init()->getPicto($keyname)))
    {
      if(str_contains($keyname, "custom-picto") && !$icon->getIsSVG())
      {
        $attributes = array_merge(array(
          "alt" =>  ""
        ), $attributes);
        return "<img src=\"{$this->urlGenerator->generate("austral_graphic_items_icon", array("keyname"=>$keyname))}\" ".$this->arrayToString($attributes)." >";
      }
      else
      {
        $attributes = array_merge(array(
          "aria-hidden" =>  "true"
        ), $attributes);
        return preg_replace("/\<svg/", "<svg ".$this->arrayToString($attributes), $icon->getContent());
      }
    }
    return "";
  }

  /**
   * arrayToString
   *
   * @param array $array
   *
   * @return string
   */
  protected function arrayToString(array $array = array()): string
  {
    $arrayToString = array();
    foreach ($array as $key => $value)
    {
      $arrayToString[] = "{$key}=\"{$value}\"";
    }
    return implode(" ", $arrayToString);
  }

}