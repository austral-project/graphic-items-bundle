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
use Austral\GraphicItemsBundle\Model\Icon;
use Austral\ToolsBundle\AustralTools;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LocalIcon
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
   * SimpleIcon constructor
   *
   * @param ContainerInterface $container
   */
  public function __construct(ContainerInterface $container)
  {
    $pictoObjects = $container->get("austral.entity_manager.graphic_items.item_category")
      ->selectAll("root.position", "ASC");

    $mapping = $container->get("austral.entity.mapping");

    /** @var ItemCategoryInterface $category */
    foreach ($pictoObjects as $category)
    {
      /** @var ItemInterface $item */
      foreach ($category->getItems() as $item)
      {
        $keyname = $item->getKeyname();
        if($fieldFileMapping = $mapping->getFieldsMappingByFieldname($item->getClassnameForMapping(), FieldFileMapping::class, "picto"))
        {
          $filePath = $fieldFileMapping->getObjectFilePath($item);
          if($filePath)
          {
            $this->icons[$keyname] = Icon::create($keyname)
              ->setTitle($item->getName())
              ->setPath($filePath)
              ->setIsSVG($this->isSVG($filePath))
              ->setContent($this->getContentFilePath($filePath));
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
   * getSimpleIcons
   * @return array
   */
  public function getIcons(): array
  {
    return $this->icons;
  }

  /**
   * getSimpleIcon
   *
   * @param string $keyname
   *
   * @return Icon|null
   */
  public function getIcon(string $keyname): ?Icon
  {
    return AustralTools::getValueByKey($this->getIcons(), $keyname, null);
  }



}