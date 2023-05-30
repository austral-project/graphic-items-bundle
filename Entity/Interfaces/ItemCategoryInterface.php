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

use Doctrine\Common\Collections\Collection;

/**
 * Austral ItemCategory Interface.
 * @author Matthieu Beurel <matthieu@austral.dev>
 */
interface ItemCategoryInterface
{

  /**
   * @return string|null
   */
  public function getName(): ?string;

  /**
   * @param string|null $name
   *
   * @return ItemCategoryInterface
   */
  public function setName(?string $name): ItemCategoryInterface;

  /**
   * @return string|null
   */
  public function getKeyname(): ?string;

  /**
   * @param string|null $keyname
   *
   * @return ItemCategoryInterface
   */
  public function setkeyname(?string $keyname): ItemCategoryInterface;

  /**
   * @return Collection
   */
  public function getItems(): Collection;

  /**
   * @param ItemInterface $item
   * @return ItemCategoryInterface
   */
  public function addItem(ItemInterface $item): ItemCategoryInterface;

  /**
   * @param ItemInterface $item
   * @return ItemCategoryInterface
   */
  public function removeItem(ItemInterface $item): ItemCategoryInterface;

  /**
   * @param Collection $items
   * @return ItemCategoryInterface
   */
  public function setItems(Collection $items): ItemCategoryInterface;

}
