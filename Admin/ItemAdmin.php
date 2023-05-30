<?php
/*
 * This file is part of the Austral Website Bundle package.
 *
 * (c) Austral <support@austral.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 
namespace Austral\GraphicItemsBundle\Admin;

use App\Entity\Austral\GraphicItemsBundle\ItemCategory;
use Austral\FormBundle\Mapper\Fieldset;
use Austral\GraphicItemsBundle\Entity\Interfaces\ItemInterface;

use Austral\AdminBundle\Admin\Admin;
use Austral\AdminBundle\Admin\AdminModuleInterface;
use Austral\AdminBundle\Admin\Event\FormAdminEvent;
use Austral\AdminBundle\Admin\Event\ListAdminEvent;

use Austral\EntityBundle\Entity\EntityInterface;
use Austral\FormBundle\Field as Field;
use Austral\ListBundle\Column as Column;

use Exception;

/**
 * GraphicItems Admin.
 * @author Matthieu Beurel <matthieu@austral.dev>
 */
class ItemAdmin extends Admin implements AdminModuleInterface
{

  /**
   * @return array
   */
  public function getEvents() : array
  {
    return array(
      FormAdminEvent::EVENT_UPDATE_BEFORE =>  "formUpdateBefore"
    );
  }

  /**
   * @param ListAdminEvent $listAdminEvent
   */
  public function configureListMapper(ListAdminEvent $listAdminEvent)
  {
    $listAdminEvent->getListMapper()
      ->addColumn(new Column\Value("name"))
      ->addColumn(new Column\Date("updated", "d/m/Y"));
  }

  /**
   * @param FormAdminEvent $formAdminEvent
   *
   * @throws Exception
   */
  public function configureFormMapper(FormAdminEvent $formAdminEvent)
  {
    $formAdminEvent->getFormMapper()
      ->addFieldset("fieldset.right")
        ->setPositionName(Fieldset::POSITION_RIGHT)
        ->add(Field\EntityField::create("category", ItemCategory::class))
      ->end();
    $formAdminEvent->getFormMapper()
      ->addFieldset("fieldset.generalInformation")
        ->add(Field\TextField::create("name"))
        ->add(Field\TextField::create("keyname"))
        ->add(Field\UploadField::create("picto"))
      ->end();
    $formAdminEvent->getFormMapper()->addPopin("popup-editor-picto", "picto", array(
        "button"  =>  array(
          "entitled"            =>  "actions.picture.edit",
          "picto"               =>  "",
          "class"               =>  "button-action"
        ),
        "popin"  =>  array(
          "id"            =>  "upload",
          "template"      =>  "uploadEditor",
        )
      )
    )
        ->add(Field\TextField::create("pictoAlt", array('entitled'=>"fields.alt.entitled")))
        ->add(Field\TextField::create("pictoReelname", array('entitled'=>"fields.reelname.entitled")))
      ->end();
  }

  /**
   * @param FormAdminEvent $formAdminEvent
   *
   * @throws Exception
   */
  protected function formUpdateBefore(FormAdminEvent $formAdminEvent)
  {
    /** @var ItemInterface|EntityInterface $object */
    $object = $formAdminEvent->getFormMapper()->getObject();
    if(!$object->getKeyname()) {
      $object->setKeyname($object->getName());
    }
  }
}