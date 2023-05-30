<?php
/*
 * This file is part of the Austral GraphicItems Bundle package.
 *
 * (c) Austral <support@austral.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Austral\GraphicItemsBundle\Listener;

use Austral\FormBundle\Event\FormEvent;
use Austral\FormBundle\Field\Base\FieldInterface;
use Austral\GraphicItemsBundle\Field\GraphicItemField;

/**
 * Austral FormListener Listener.
 * @author Matthieu Beurel <matthieu@austral.dev>
 * @final
 */
class FormListener
{

  /**
   * @param FormEvent $formEvent
   * @param string|null $type
   *
   * @throws \Exception
   */
  public function formAddAutoFields(FormEvent $formEvent, ?string $type = null)
  {
    /** @var FieldInterface $field */
    foreach($formEvent->getFormMapper()->allFields() as $field)
    {
      if($field instanceof GraphicItemField)
      {
        $options = $field->getOptions();
        $options["attr"]["autocomplete"] = "off";
        $options["attr"]["data-popin-update-input"] = "field-graphic-element-{$field->getFieldname()}";
        $field->setPopinId("popup-graphic-items-{$field->getFieldname()}")
          ->setOptions($options);
        $formEvent->getFormMapper()->addPopin("popup-graphic-items-{$field->getFieldname()}", $field->getFieldname(), array(
          "button"  =>  array(
            "entitled"      =>  "graphic-item.button.choice",
            "picto"         =>  "austral-picto-cog",
            "class"         =>  "button-picto",
          ),
          "popin"  =>  array(
            "id"            =>  "master",
            "template"      =>  "graphicItems",
          )
        ));
      }
    }

  }


}