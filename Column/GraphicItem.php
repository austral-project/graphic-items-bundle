<?php
/*
 * This file is part of the Austral List Bundle package.
 *
 * (c) Austral <support@austral.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Austral\GraphicItemsBundle\Column;

use Austral\ListBundle\Column\Base\Column;

/**
 * Austral Column Image.
 * @author Matthieu Beurel <matthieu@austral.dev>
 * @final
 */
class GraphicItem extends Column
{

  /**
   * @var string
   */
  protected string $type = "graphic-item";

  /**
   * @var string|null
   */
  protected ?string $defaultTemplate = null;

  /**
   * Choices constructor.
   *
   * @param string $fieldname
   * @param string|null $entitled
   * @param array $options
   */
  public function __construct(string $fieldname, ?string $entitled = null, array $options = array())
  {
    parent::__construct($fieldname, $entitled, $options);
  }

  /**
   * @return string|null
   */
  public function getDefaultTemplate(): ?string
  {
    return $this->defaultTemplate;
  }

}