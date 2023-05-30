<?php
/*
 * This file is part of the Austral GraphicItems Bundle package.
 *
 * (c) Austral <support@austral.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Austral\GraphicItemsBundle\Repository;

use Austral\GraphicItemsBundle\Entity\Interfaces\ItemCategoryInterface;
use Austral\EntityBundle\Repository\EntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

/**
 * App ItemCategory Repository.
 * @author Matthieu Beurel <matthieu@austral.dev>
 * @final
 */
class ItemCategoryRepository extends EntityRepository
{

  /**
   * @param string $keyname
   * @param \Closure|null $closure
   *
   * @return ItemCategoryInterface|null
   * @throws NonUniqueResultException
   */
  public function retreiveByKeyname(string $keyname, \Closure $closure = null): ?ItemCategoryInterface
  {
    return $this->retreiveByKey("keyname", $keyname, $closure);
  }



  /**
   * @param string $orderByAttribute
   * @param string $orderByType
   * @param \Closure|null $closure
   *
   * @return ArrayCollection|array
   * @throws \Doctrine\ORM\Query\QueryException
   */
  public function selectAll(string $orderByAttribute = 'id', string $orderByType = "ASC", \Closure $closure = null)
  {
    $queryBuilder = $this->createQueryBuilder('root');
    if(strpos($orderByAttribute, ".") === false)
    {
      $orderByAttribute = "root.".$orderByAttribute;
    }
    $queryBuilder = $this->queryBuilderExtends("select-all", $queryBuilder);
    $queryBuilder->leftJoin("root.items", "items")->addSelect("items");
    $queryBuilder->orderBy($orderByAttribute, $orderByType);
    $queryBuilder->indexBy("root", "root.id");
    if($closure instanceof \Closure)
    {
      $closure->call($this, $queryBuilder);
    }
    $query = $queryBuilder->getQuery();
    try {
      $objects = $query->execute();
    } catch (NoResultException $e) {
      $objects = array();
    }
    return $objects;
  }

}
