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
use Austral\GraphicItemsBundle\Entity\Item as BaseItem;

use Doctrine\ORM\Mapping as ORM;

/**
 * Austral Item Entity.
 *
 * @author Matthieu Beurel <matthieu@austral.dev>
 *
 * @ORM\Table(name="austral_graphic_items_item")
 * @ORM\Entity(repositoryClass="Austral\GraphicItemsBundle\Repository\ItemRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Item extends BaseItem
{
  public function __construct()
  {
      parent::__construct();
  }
}
