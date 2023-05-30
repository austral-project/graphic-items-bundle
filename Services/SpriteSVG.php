<?php

namespace Austral\GraphicItemsBundle\Services;

class SpriteSVG
{
  /**
   * The URI for the SVG namespace.
   *
   * @var string
   */
  const SVG_NS = 'http://www.w3.org/2000/svg';

  /**
   * Fraction of icon size to pad icons with.
   *
   * @var float
   */
  const PAD = .05;

  /**
   * The horizontal/vertical center-to-center distance between icons.
   *
   * @var integer
   */
  private int $grid = 100;

  /**
   * The nominal size of the icons.
   *
   * @var integer
   */
  private int $nominal = 64;

  /**
   * The SVG document we are creating.
   *
   * @var \DOMDocument
   */
  private \DOMDocument $out;

  /**
   * The height of the resulting sprite, extended as icons are added.
   *
   * @var integer
   */
  private int $maxheight = 0;

  /**
   * The width of the resulting sprite.
   *
   * @var integer
   */
  private int $maxwidth;

  /**
   * The default state icon color
   *
   * @var string
   */
  private string $default = '#a49d95';

  /**
   * The selected state icon color
   *
   * @var string
   */
  private string $selected = '#6a635a';

  /**
   * The hover state icon color
   *
   * @var string
   */
  private string $hover = '#ed693b';

  /**
   * The active state icon color
   *
   * @var string
   */
  private string $active = '#eeeeee';

  /**
   * Construct an empty Sprite.
   *
   * @param integer $grid Size (height and width) of grid.
   * @throws \DOMException
   */
  public function __construct(int $grid = 100) {
    $this->out = new \DOMDocument();
    $this->out->formatOutput = true;
    $this->grid = $grid;
    $root = $this->out->createElementNS(self::SVG_NS, 'svg:svg');
    $this->out->appendChild($root);
    $root->setAttribute('xmlns', self::SVG_NS);
    $this->maxwidth = (4 * $this->grid);
  }

  /**
   * Make IDs unique by prefixing them.
   *
   * @param \DOMElement $element Element whose attributes will be checked.
   * @param string $prefix  Prefix to add.
   *
   * @return SpriteSVG
   */
  private function _prefixId(\DOMElement $element, string $prefix): SpriteSVG
  {
    if ($element->hasAttribute('id')) {
      $element->setAttribute('id', $prefix . $element->getAttribute('id'));
    }
    foreach (array('clip-path', 'mask') as $attr) {
      if ($element->hasAttribute($attr)) {
        $ref = $element->getAttribute($attr);
        $ref = str_replace('url(#', 'url(#' . $prefix, $ref);
        $element->setAttribute($attr, $ref);
      }
    }
    return $this;
  }

  /**
   * Load an SVG file and place it at $row, $col in the sprite.
   *
   * @param string $keyname
   * @param string $filename File to load.
   * @param mixed $fill Fill color (e.g., #FFFFFF) or false for none.
   * @param integer $row Row at which to locate icon in sprite.
   * @param integer $col Column at which to locate icon in sprite.
   *
   * @return SpriteSVG
   * @throws \DOMException
   */
  public function add(string $keyname, string $filename, mixed $fill, int $row, int $col = 0): SpriteSVG
  {
    static $gensym = 0;
    $prefix = 'x' . ($gensym++);

    $in = new \DOMDocument();
    $in->load($filename);
    $src = $in->documentElement;

    $this->maxheight = max($this->maxheight, ($this->grid * ($row + 1)));

    // Make IDs unique.
    foreach (array('svg', 'path', 'clipPath', 'g', 'image', 'mask') as $tag) {
      foreach ($in->getElementsByTagName($tag) as $element) {
        $this->_prefixId($element, $prefix);
      }
    }

    /** @var \DOMElement $element */
    foreach ($in->getElementsByTagName("style") as $element) {
    }


    // Fill all the paths.
    foreach (array('svg', 'path', 'clipPath', 'g', 'rect') as $tag) {
      foreach ($in->getElementsByTagName($tag) as $element) {
        $style = $element->getAttribute('style');
        $style = preg_replace('/fill:#?[0-9A-Fa-f]+;/',
          'fill:' . $fill . ';', $style);
        $style = preg_replace('/stroke:#?[0-9A-Fa-f]+;/',
          'stroke:' . $fill . ';', $style);
        $element->setAttribute('style', $style);
      }
    }
    // Copy source <svg> element to output <g> element.
    $g = $this->out->createElementNS(self::SVG_NS, 'g');
    $this->out->documentElement->appendChild($g);
    $g->setAttribute('id', $keyname);

    foreach ($src->childNodes as $child) {
      if ($child->nodeType === XML_ELEMENT_NODE
        && $child->tagName !== 'metadata'
      ) {
        $g->appendChild($this->out->importNode($child, true));
      }
    }
    return $this;
  }

  /**
   * Load an SVG file, colorize all states, and place it at $row the sprite.
   *
   * @param string $keyname
   * @param string $filename File to load.
   * @param integer $row Row at which to locate icon in sprite.
   *
   * @return SpriteSVG
   * @throws \DOMException
   */
  public function addAllStates(string $keyname, string $filename, int $row): SpriteSVG
  {
    $this->add($keyname, $filename, $this->default, $row);
    return $this;
  }

  /**
   * Echo the resulting Sprite.
   *
   * @return string
   */
  public function output(): string
  {
    $root = $this->out->documentElement;
    $this->out->normalizeDocument();
    return $this->out->saveXML();
  }
}