<?php
/*
 * This file is part of the App package.
 *
 * (c) Yipikai <support@yipikai.studio>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Austral\GraphicItemsBundle\Model;

class Picto
{
  
  /**
   * @var string|null
   */
  protected ?string $keyname = null;

  /**
   * @var string|null
   */
  protected ?string $title = null;

  /**
   * @var string|null
   */
  protected ?string $hexa = null;

  /**
   * @var string|null
   */
  protected ?string $content = null;

  /**
   * @var string|null
   */
  protected ?string $path = null;
  
  /**
   * @var boolean
   */
  protected bool $isSVG = false;

  /**
   * @var string
   */
  protected string $viewBox = "";

  /**
   * @var array
   */
  protected array $svgPath = array();

  /**
   * create
   *
   * @param string|null $keyname
   *
   * @return Picto
   */
  public static function create(string $keyname = null): Picto
  {
    return (new self($keyname));
  }

  /**
   * Icon constructor
   *
   * @param string|null $keyname
   */
  public function __construct(string $keyname = null)
  {
    $this->keyname = $keyname;
  }

  /**
   * @return string|null
   */
  public function getKeyname(): ?string
  {
    return $this->keyname;
  }

  /**
   * @param string|null $keyname
   *
   * @return $this
   */
  public function setKeyname(?string $keyname): Picto
  {
    $this->keyname = $keyname;
    return $this;
  }

  /**
   * @return string|null
   */
  public function getTitle(): ?string
  {
    return $this->title;
  }

  /**
   * @param string|null $title
   *
   * @return $this
   */
  public function setTitle(?string $title): Picto
  {
    $this->title = $title;
    return $this;
  }

  /**
   * @return string|null
   */
  public function getHexa(): ?string
  {
    return $this->hexa;
  }

  /**
   * @param string|null $hexa
   *
   * @return $this
   */
  public function setHexa(?string $hexa): Picto
  {
    $this->hexa = $hexa;
    return $this;
  }

  /**
   * @return string|null
   */
  public function getContent(): ?string
  {
    return $this->content;
  }

  /**
   * @param string|null $content
   *
   * @return Picto
   */
  public function setContent(?string $content): Picto
  {
    $this->content = $content;
    return $this;
  }

  /**
   * @return string|null
   */
  public function getPath(): ?string
  {
    return $this->path;
  }

  /**
   * @param string|null $path
   *
   * @return $this
   */
  public function setPath(?string $path): Picto
  {
    $this->path = $path;
    return $this;
  }

  /**
   * @return bool
   */
  public function getIsSVG(): bool
  {
    return $this->isSVG;
  }

  /**
   * @param bool $isSVG
   *
   * @return Picto
   */
  public function setIsSVG(bool $isSVG): Picto
  {
    $this->isSVG = $isSVG;
    return $this;
  }

  /**
   * @return string
   */
  public function getViewBox(): string
  {
    return $this->viewBox;
  }

  /**
   * @param string $viewBox
   *
   * @return Picto
   */
  public function setViewBox(string $viewBox): Picto
  {
    $this->viewBox = $viewBox;
    return $this;
  }

  /**
   * @return array
   */
  public function getSvgPath(): array
  {
    return $this->svgPath;
  }

  /**
   * @param array $svgPath
   *
   * @return $this
   */
  public function setSvgPath(array $svgPath): Picto
  {
    $this->svgPath = $svgPath;
    return $this;
  }

}