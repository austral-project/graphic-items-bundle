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

class Icon
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
  protected ?string $source = null;

  /**
   * @var string|null
   */
  protected ?string $path = null;

  /**
   * create
   *
   * @param string|null $keyname
   *
   * @return Icon
   */
  public static function create(string $keyname = null): Icon
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
  public function setKeyname(?string $keyname): Icon
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
  public function setTitle(?string $title): Icon
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
  public function setHexa(?string $hexa): Icon
  {
    $this->hexa = $hexa;
    return $this;
  }

  /**
   * @return string|null
   */
  public function getSource(): ?string
  {
    return $this->source;
  }

  /**
   * @param string|null $source
   *
   * @return $this
   */
  public function setSource(?string $source): Icon
  {
    $this->source = $source;
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
  public function setPath(?string $path): Icon
  {
    $this->path = $path;
    return $this;
  }

}