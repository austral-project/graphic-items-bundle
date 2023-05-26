<?php
/*
 * This file is part of the Austral GraphicItems Bundle package.
 *
 * (c) Austral <support@austral.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Austral\GraphicItemsBundle\Field;

use Austral\FormBundle\Field\Base\Field;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

/**
 * Austral Field GraphicItems.
 * @author Matthieu Beurel <matthieu@austral.dev>
 * @final
 */
class GraphicItemField extends Field
{

  /**
   * @param $fieldname
   * @param array $options
   *
   * @return $this
   */
  public static function create($fieldname, array $options = array()): GraphicItemField
  {
    return new self($fieldname, $options);
  }

  /**
   * TextField constructor.
   *
   * @param string $fieldname
   * @param array $options
   */
  public function __construct($fieldname, array $options = array())
  {
    parent::__construct($fieldname, $options);
    $this->symfonyFormType = HiddenType::class;
    if($this->isDefaultTemplate)
    {
      $this->options["template"]["path"] = "graphic-item-field.html.twig";
    }
  }

}