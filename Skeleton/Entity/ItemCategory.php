##php##
/*
 * This file is autogenerate and part of the Austral GraphicItems Bundle package.
 *
 * (c) Austral <support@austral.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Entity\Austral\GraphicItemsBundle;
use Austral\GraphicItemsBundle\Entity\ItemCategory as BaseItemCategory;

use Doctrine\ORM\Mapping as ORM;

/**
 * Austral ItemCategory Entity.
 *
 * @author Matthieu Beurel <matthieu@austral.dev>
 *
 * @ORM\Table(name="austral_graphic_items_item_category")
 * @ORM\Entity(repositoryClass="Austral\GraphicItemsBundle\Repository\ItemCategoryRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Item extends BaseItemCategory
{
  public function __construct()
  {
      parent::__construct();
  }
}
