<?php
/*
 * This file is part of the App package.
 *
 * (c) Yipikai <support@yipikai.studio>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Austral\GraphicItemsBundle\Services;

use Austral\EntityFileBundle\File\Mapping\FieldFileMapping;
use Austral\GraphicItemsBundle\Entity\Interfaces\ItemCategoryInterface;
use Austral\GraphicItemsBundle\Entity\Interfaces\ItemInterface;
use Austral\GraphicItemsBundle\Model\Picto;
use Austral\ToolsBundle\AustralTools;
use Symfony\Component\DependencyInjection\ContainerInterface;

class CustomPicto
{

  /**
   * @var string
   */
  protected string $iconsPath;

  /**
   * @var array
   */
  protected array $icons = array();

  /**
   * @var array
   */
  protected array $iconsByCateg = array();

  /**
   * SimplePicto constructor
   *
   * @param ContainerInterface $container
   *
   * @throws \Exception
   */
  public function __construct(ContainerInterface $container)
  {
    $pictoObjects = $container->get("austral.entity_manager.graphic_items.item_category")
      ->selectAll("root.position", "ASC");

    $mapping = $container->get("austral.entity.mapping");

    /** @var ItemCategoryInterface $category */
    foreach ($pictoObjects as $category)
    {
      $this->iconsByCateg[$category->getId()] = array(
        "name"    =>  $category->getName(),
        "pictos"  =>  array()
      );
      /** @var ItemInterface $item */
      foreach ($category->getItems() as $item)
      {
        $keyname = $item->getKeyname();
        if($fieldFileMapping = $mapping->getFieldsMappingByFieldname($item->getClassnameForMapping(), FieldFileMapping::class, "picto"))
        {
          $filePath = $fieldFileMapping->getObjectFilePath($item);
          if($filePath)
          {
            $keyname = "custom-picto-{$keyname}";
            $icon = Picto::create($keyname)
              ->setTitle($item->getName())
              ->setPath($filePath)
              ->setIsSVG($this->isSVG($filePath))
              ->setContent($this->getContentFilePath($filePath));
            $this->icons[$keyname] = $icon;
            $this->iconsByCateg[$category->getId()]["pictos"][$keyname] = $icon;
          }
        }
      }
    }
  }

  /**
   * getContentFilePath
   * @param string $filePath
   * @return string
   */
  protected function getContentFilePath(string $filePath): string
  {
    $content = file_get_contents($filePath);
    if(!$this->isSVG($filePath))
    {
      $type = pathinfo($filePath, PATHINFO_EXTENSION);
      $content = 'data:image/' . $type . ';base64,' . base64_encode($content);
    }
    return $content;
  }

  /**
   * isSVG
   * @param string $filePath
   * @return bool
   */
  protected function isSVG(string $filePath): bool
  {
    return str_contains(AustralTools::mimeType($filePath), "svg");
  }

  /**
   * getPictos
   * @return array
   */
  public function getPictos(): array
  {
    return $this->icons;
  }

  /**
   * getPictos
   * @return array
   */
  public function getPictosByCateg(): array
  {
    return $this->iconsByCateg;
  }

  /**
   * getPicto
   *
   * @param string $keyname
   *
   * @return Picto|null
   */
  public function getPicto(string $keyname): ?Picto
  {
    return AustralTools::getValueByKey($this->getPictos(), $keyname, null);
  }



}