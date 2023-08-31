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

use Austral\EntityBundle\Mapping\Mapping;
use Austral\EntityBundle\ORM\AustralQueryBuilder;
use Austral\EntityFileBundle\File\Mapping\FieldFileMapping;
use Austral\GraphicItemsBundle\Entity\Interfaces\ItemInterface;
use Austral\GraphicItemsBundle\EntityManager\ItemEntityManager;
use Austral\GraphicItemsBundle\Model\Picto;
use Austral\ToolsBundle\AustralTools;
use Austral\ToolsBundle\Services\Debug;

/**
 * Class CustomPicto
 * @package Austral\GraphicItemsBundle\Services
 *
 * @author Matthieu Beurel <matthieu@yipikai.studio>
 * @final
 */
class CustomPicto
{

  /**
   * @var ItemEntityManager
   */
  protected ItemEntityManager $itemEntityManager;

  /**
   * @var Mapping
   */
  protected Mapping $mapping;

  /**
   * @var Debug
   */
  protected Debug $debug;

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
   * @var bool
   */
  protected bool $isInitialise = false;

  /**
   * SimplePicto constructor
   *
   * @param ItemEntityManager $itemEntityManager
   * @param Mapping $mapping
   * @param Debug $debug
   */
  public function __construct(ItemEntityManager $itemEntityManager, Mapping $mapping, Debug $debug)
  {
    $this->itemEntityManager = $itemEntityManager;
    $this->mapping = $mapping;
    $this->debug = $debug;
  }

  /**
   * init
   *
   * @param $force
   *
   * @return $this
   * @throws \Exception
   */
  public function init($force = false): CustomPicto
  {
    $this->debug->stopWatchStart("austral.customPicto.init", "austral.graphic_items");
    if(!$this->isInitialise || $force)
    {
      $pictoObjects = $this->itemEntityManager->selectAll("category.position", "ASC", function(AustralQueryBuilder $australQueryBuilder){
        $australQueryBuilder->leftJoin("root.category", "category")->addSelect("category")
        ->addOrderBy("root.name", "ASC");

      });
      /** @var ItemInterface $item */
      foreach ($pictoObjects as $item)
      {
        $categoryId = "default";
        if($item->getCategory())
        {
          $categoryId = $item->getCategory()->getId();
        }

        if(!array_key_exists($categoryId, $this->iconsByCateg))
        {
          $this->iconsByCateg[$categoryId] = array(
            "name"    =>  $categoryId === "default" ? "default" : $item->getCategory()->getName(),
            "pictos"  =>  array()
          );
        }
        $keyname = $item->getKeyname();
        if($fieldFileMapping = $this->mapping->getFieldsMappingByFieldname($item->getClassnameForMapping(), FieldFileMapping::class, "picto"))
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
            $this->iconsByCateg[$categoryId]["pictos"][$keyname] = $icon;
          }
        }
      }
      $this->isInitialise = true;
    }
    $this->debug->stopWatchStop("austral.customPicto.init");
    return $this;
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