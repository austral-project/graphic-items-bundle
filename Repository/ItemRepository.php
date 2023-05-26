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

use Austral\GraphicItemsBundle\Entity\Interfaces\ItemInterface;
use Austral\EntityBundle\Repository\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;

/**
 * App Item Repository.
 * @author Matthieu Beurel <matthieu@austral.dev>
 * @final
 */
class ItemRepository extends EntityRepository
{

  /**
   * @param string $keyname
   * @param \Closure|null $closure
   *
   * @return ItemInterface|null
   * @throws NonUniqueResultException
   */
  public function retreiveByKeyname(string $keyname, \Closure $closure = null): ?ItemInterface
  {
    return $this->retreiveByKey("keyname", $keyname, $closure);
  }

}
