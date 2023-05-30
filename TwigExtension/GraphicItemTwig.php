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
   * @param string|null $keyname
   * @return string
   */
  public function render(?string $keyname): string
  {
    if($keyname && ($icon = $this->graphicItemManagement->getPicto($keyname)))
    {
      if(str_contains($keyname, "custom-picto"))
      {
        return "<img src=\"{$this->urlGenerator->generate("austral_graphic_items_icon", array("keyname"=>$keyname))}\" alt=\"\" >";
      }
      else
      {
        return "<svg viewBox=\"{$icon->getViewBox()}\" xmlns=\"http://www.w3.org/2000/svg\"><use xlink:href=\"{$this->urlGenerator->generate("austral_graphic_items_icons")}#{$keyname}\"></use></svg>";
      }
    }
    return "";
  }

}