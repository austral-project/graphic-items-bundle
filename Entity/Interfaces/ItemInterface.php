<?php
/*
 * This file is part of the Austral GraphicItems Bundle package.
 *
 * (c) Austral <support@austral.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Austral\GraphicItemsBundle\Entity\Interfaces;

/**
 * Austral Item Interface.
 * @author Matthieu Beurel <matthieu@austral.dev>
 */
interface ItemInterface
{

  /**
   * @return string|null
   */
  public function getName(): ?string;

  /**
   * @param string|null $name
   *
   * @return ItemInterface
   */
  public function setName(?string $name): ItemInterface;

  /**
   * @return string|null
   */
  public function getKeyname(): ?string;

  /**
   * @param string|null $keyname
   *
   * @return ItemInterface
   */
  public function setKeyname(?string $keyname): ItemInterface;

  /**
   * @return bool
   */
  public function getIsActive(): bool;

  /**
   * @param bool $isActive
   *
   * @return ItemInterface
   */
  public function setIsActive(bool $isActive): ItemInterface;

  /**
   * @return string|null
   */
  public function getSimpleIcon(): ?string;

  /**
   * @param string|null $simpleIcon
   *
   * @return ItemInterface
   */
  public function setSimpleIcon(?string $simpleIcon): ItemInterface;

  /**
   * @return string|null
   */
  public function getPicto(): ?string;

  /**
   * @param string|null $picto
   *
   * @return ItemInterface
   */
  public function setPicto(?string $picto): ItemInterface;

  /**
   * @return string|null
   */
  public function getPictoReelname(): ?string;

  /**
   * @param string|null $pictoReelname
   *
   * @return ItemInterface
   */
  public function setPictoReelname(?string $pictoReelname): ItemInterface;

  /**
   * @return string|null
   */
  public function getPictoAlt(): ?string;

  /**
   * @param string|null $pictoAlt
   *
   * @return ItemInterface
   */
  public function setPictoAlt(?string $pictoAlt): ItemInterface;

}
