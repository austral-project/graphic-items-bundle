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
use Austral\GraphicItemsBundle\Entity\Interfaces\ItemInterface;

use Austral\EntityBundle\Entity\Entity;
use Austral\EntityBundle\Entity\EntityInterface;
use Austral\EntityBundle\Entity\Traits\EntityTimestampableTrait;
use Austral\EntityBundle\Entity\Interfaces\FileInterface;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * App ItemCategory Entity.
 * @author Matthieu Beurel <matthieu@austral.dev>
 * @abstract
 * @ORM\MappedSuperclass
 */
abstract class ItemCategory extends Entity implements ItemInterface, EntityInterface, FileInterface
{

  use EntityTimestampableTrait;

  /**
   * @var string
   * @ORM\Column(name="id", type="string", length=40)
   * @ORM\Id
   */
  protected $id;

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
   * GraphicItems constructor
   * @throws \Exception
   */
  public function __construct()
  {
    parent::__construct();
    $this->id = Uuid::uuid4()->toString();
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
  public function setName(?string $name): ItemCategory
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
  public function setKeyname(?string $keyname): ItemCategory
  {
    $this->keyname = $keyname;
    return $this;
  }

}
