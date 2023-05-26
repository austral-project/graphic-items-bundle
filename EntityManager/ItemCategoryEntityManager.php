<?php
/*
 * This file is part of the Austral GraphicItems Bundle package.
 *
 * (c) Austral <support@austral.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Austral\GraphicItemsBundle\EntityManager;

use Austral\EntityBundle\Entity\Interfaces\TranslateMasterInterface;

use Austral\EntityBundle\EntityManager\EntityManager;
use Austral\GraphicItemsBundle\Entity\Interfaces\ItemCategoryInterface;
use Austral\GraphicItemsBundle\Repository\ItemCategoryRepository;
use Doctrine\ORM\NonUniqueResultException;

/**
 * Austral ItemCategory EntityManager.
 * @author Matthieu Beurel <matthieu@austral.dev>
 * @final
 */
class ItemCategoryEntityManager extends EntityManager
{

  /**
   * @var ItemCategoryRepository
   */
  protected $repository;

  /**
   * @param array $values
   *
   * @return ItemCategoryInterface
   */
  public function create(array $values = array()): ItemCategoryInterface
  {
    /** @var ItemCategoryInterface|TranslateMasterInterface $object */
    $object = parent::create($values);
    return $object;
  }

  /**
   * @param $keyname
   * @param \Closure|null $closure
   *
   * @return ItemCategoryInterface|null
   * @throws NonUniqueResultException
   */
  public function retreiveByKeyname($keyname, \Closure $closure = null): ?ItemCategoryInterface
  {
    return $this->repository->retreiveByKeyname($keyname, $closure);
  }

}

