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

use Austral\GraphicItemsBundle\Entity\Interfaces\ItemInterface;
use Austral\EntityBundle\Entity\Interfaces\TranslateMasterInterface;
use Austral\GraphicItemsBundle\Repository\ItemRepository;

use Austral\EntityBundle\EntityManager\EntityManager;
use Doctrine\ORM\NonUniqueResultException;

/**
 * Austral Item EntityManager.
 * @author Matthieu Beurel <matthieu@austral.dev>
 * @final
 */
class ItemEntityManager extends EntityManager
{

  /**
   * @var ItemRepository
   */
  protected $repository;

  /**
   * @param array $values
   *
   * @return ItemInterface
   */
  public function create(array $values = array()): ItemInterface
  {
    /** @var ItemInterface|TranslateMasterInterface $object */
    $object = parent::create($values);
    return $object;
  }

  /**
   * @param $keyname
   * @param \Closure|null $closure
   *
   * @return ItemInterface|null
   * @throws NonUniqueResultException
   */
  public function retreiveByKeyname($keyname, \Closure $closure = null): ?ItemInterface
  {
    return $this->repository->retreiveByKeyname($keyname, $closure);
  }

}

