<?php
/*
 * This file is part of the Austral GraphicItems Bundle package.
 *
 * (c) Austral <support@austral.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Austral\GraphicItemsBundle\Entity;
use Austral\GraphicItemsBundle\Entity\Interfaces\ItemCategoryInterface;

use Austral\EntityBundle\Entity\Entity;
use Austral\EntityBundle\Entity\EntityInterface;
use Austral\EntityBundle\Entity\Traits\EntityTimestampableTrait;

use Austral\GraphicItemsBundle\Entity\Interfaces\ItemInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * App ItemCategory Entity.
 * @author Matthieu Beurel <matthieu@austral.dev>
 * @abstract
 * @ORM\MappedSuperclass
 */
abstract class ItemCategory extends Entity implements ItemCategoryInterface, EntityInterface
{

  use EntityTimestampableTrait;

  /**
   * @var string
   * @ORM\Column(name="id", type="string", length=40)
   * @ORM\Id
   */
  protected $id;

  /**
   * @var Collection
   * @ORM\OneToMany(targetEntity="Austral\GraphicItemsBundle\Entity\Interfaces\ItemInterface", mappedBy="category", cascade={"persist", "remove"})
   */
  protected Collection $items;

  /**
   * @var string|null
   * @ORM\Column(name="name", type="string", length=255, nullable=true )
   */
  protected ?string $name = null;
  
  /**
   * @var string|null
   * @ORM\Column(name="keyname", type="string", length=255, nullable=true )
   */
  protected ?string $keyname = null;

  /**
   * @var int|null
   * @Gedmo\SortablePosition
   * @ORM\Column(name="position", type="integer", nullable=false )
   */
  protected ?int $position;

  /**
   * GraphicItems constructor
   * @throws \Exception
   */
  public function __construct()
  {
    parent::__construct();
    $this->id = Uuid::uuid4()->toString();
    $this->items = new ArrayCollection();
  }

  public function __toString()
  {
    return $this->name;
  }

  /**
   * @return Collection
   */
  public function getItems(): Collection
  {
    return $this->items;
  }

  /**
   * @param ItemInterface $item
   * @return ItemCategoryInterface
   */
  public function addItem(ItemInterface $item): ItemCategoryInterface
  {
    if(!$this->items->contains($item))
    {
      $item->setCategory($this);
      $this->items->add($item);
    }
    return $this;
  }

  /**
   * @param ItemInterface $item
   * @return ItemCategoryInterface
   */
  public function removeItem(ItemInterface $item): ItemCategoryInterface
  {
    if($this->items->contains($item))
    {
      $item->setCategory(null);
      $this->items->removeElement($item);
    }
    return $this;
  }

  /**
   * @param Collection $items
   * @return ItemCategoryInterface
   */
  public function setItems(Collection $items): ItemCategoryInterface
  {
    $this->items = $items;
    return $this;
  }

  /**
   * @return string|null
   */
  public function getName(): ?string
  {
    return $this->name;
  }

  /**
   * @param string|null $name
   *
   * @return $this
   */
  public function setName(?string $name): ItemCategoryInterface
  {
    $this->name = $name;
    return $this;
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
  public function setKeyname(?string $keyname): ItemCategoryInterface
  {
    $this->keyname = $this->keynameGenerator($keyname);
    return $this;
  }

  /**
   * Get position
   * @return int|null
   */
  public function getPosition(): ?int
  {
    return $this->position;
  }

  /**
   * Set position
   *
   * @param int|null $position
   *
   * @return ItemCategoryInterface
   */
  public function setPosition(?int $position): ItemCategoryInterface
  {
    $this->position = $position;
    return $this;
  }

}
