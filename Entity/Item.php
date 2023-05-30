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
use Austral\GraphicItemsBundle\Entity\Interfaces\ItemInterface;

use Austral\EntityBundle\Entity\Entity;
use Austral\EntityBundle\Entity\EntityInterface;
use Austral\EntityBundle\Entity\Traits\EntityTimestampableTrait;
use Austral\EntityBundle\Entity\Interfaces\FileInterface;
use Austral\EntityFileBundle\Entity\Traits\EntityFileTrait;
use Austral\EntityFileBundle\Annotation as AustralFile;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * App Item Entity.
 * @author Matthieu Beurel <matthieu@austral.dev>
 * @abstract
 * @ORM\MappedSuperclass
 */
abstract class Item extends Entity implements ItemInterface, EntityInterface, FileInterface
{

  use EntityTimestampableTrait;
  use EntityFileTrait;

  /**
   * @var string
   * @ORM\Column(name="id", type="string", length=40)
   * @ORM\Id
   */
  protected $id;

  /**
   * @var ItemCategoryInterface|null
   * @ORM\ManyToOne(targetEntity="Austral\GraphicItemsBundle\Entity\Interfaces\ItemCategoryInterface", inversedBy="items")
   * @ORM\JoinColumn(name="item_category_id", referencedColumnName="id", onDelete="SET NULL")
   */
  protected ?ItemCategoryInterface $category=null;

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
   * @var string|null
   * @ORM\Column(name="picto", type="string", length=255, nullable=true)
   * @AustralFile\UploadParameters(configName="graphic_items_picto", virtualnameField="pictoReelname")
   * @AustralFile\ImageSize()
   */
  protected ?string $picto = null;

  /**
   * @var string|null
   * @ORM\Column(name="picto_reelname", type="string", length=255, nullable=true)
   */
  protected ?string $pictoReelname = null;

  /**
   * @var string|null
   * @ORM\Column(name="picto_alt", type="string", length=255, nullable=true)
   */
  protected ?string $pictoAlt = null;
  
  /**
   * GraphicItems constructor
   * @throws \Exception
   */
  public function __construct()
  {
    parent::__construct();
    $this->id = Uuid::uuid4()->toString();
  }

  /**
   * @return string
   * @throws \Exception
   */
  public function __toString()
  {
    return $this->name;
  }

  /**
   * @return ItemCategoryInterface|null
   */
  public function getCategory(): ?ItemCategoryInterface
  {
    return $this->category;
  }

  /**
   * @param ItemCategoryInterface|null $category
   * @return Item
   */
  public function setCategory(?ItemCategoryInterface $category): Item
  {
    $this->category = $category;
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
   * @return ItemInterface
   */
  public function setName(?string $name): ItemInterface
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
   * @return ItemInterface
   */
  public function setKeyname(?string $keyname): ItemInterface
  {
    $this->keyname = $this->keynameGenerator($keyname);
    return $this;
  }

  /**
   * @return string|null
   */
  public function getPicto(): ?string
  {
    return $this->picto;
  }

  /**
   * @param string|null $picto
   *
   * @return ItemInterface
   */
  public function setPicto(?string $picto): ItemInterface
  {
    $this->picto = $picto;
    return $this;
  }

  /**
   * @return string|null
   */
  public function getPictoReelname(): ?string
  {
    return $this->pictoReelname;
  }

  /**
   * @param string|null $pictoReelname
   *
   * @return ItemInterface
   */
  public function setPictoReelname(?string $pictoReelname): ItemInterface
  {
    $this->pictoReelname = $pictoReelname;
    return $this;
  }

  /**
   * @return string|null
   */
  public function getPictoAlt(): ?string
  {
    return $this->pictoAlt;
  }

  /**
   * @param string|null $pictoAlt
   *
   * @return ItemInterface
   */
  public function setPictoAlt(?string $pictoAlt): ItemInterface
  {
    $this->pictoAlt = $pictoAlt;
    return $this;
  }

}
