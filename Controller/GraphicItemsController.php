<?php
/*
 * This file is part of the Austral GraphicItems Bundle package.
 *
 * (c) Austral <support@austral.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Austral\GraphicItemsBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Austral GraphicItems Controller Abstract.
 * @author Matthieu Beurel <matthieu@austral.dev>
 * @final
 */
class GraphicItemsController  implements ContainerAwareInterface
{
  use ContainerAwareTrait;

  public function icon(Request $request, string $keyname)
  {
    header("Access-Control-Allow-Origin: *");
    header("Austral: Generate");
    header('Access-Control-Expose-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description, Content-Length, Cache-Control');
    $graphicItemsManagement = $this->container->get('austral.graphic_items.management')->init();
    if($icon = $graphicItemsManagement->getPicto($keyname))
    {
      $lastModifiedTime = filemtime($icon->getPath());
      $etag = 'W/"' . md5($lastModifiedTime) . '"';
      header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $lastModifiedTime) . " GMT");
      header('Cache-Control: public, max-age=31536000, must-revalidate'); // On peut ici changer la durée de validité du cache
      header("Etag: $etag");

      if (
        (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) === $lastModifiedTime) ||
        (isset($_SERVER['HTTP_IF_NONE_MATCH']) && $etag === trim($_SERVER['HTTP_IF_NONE_MATCH']))
      ) {
        // 304 if file is not modified
        header('HTTP/2 304 Not Modified');
        exit();
      }
      $contentFile = file_get_contents($icon->getPath());
      $response = new Response($contentFile);
      $response->headers->set('Content-Type', "image/svg+xml");
      $response->headers->set('Content-Length', filesize($icon->getPath()));
      return $response;
    }
    throw new NotFoundHttpException("Icon not found");
  }

  public function icons(Request $request)
  {
    header("Access-Control-Allow-Origin: *");
    header("Austral: Generate");
    header('Access-Control-Expose-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description, Content-Length, Cache-Control');
    $graphicItemsManagement = $this->container->get('austral.graphic_items.management');
    $spriteSVG = $graphicItemsManagement->spriteSVG();

    $response = new Response($spriteSVG->output());
    $response->headers->set('Content-Type', "image/svg+xml");
    //$response->headers->set('Content-Length', filesize($icon->getPath()));
    return $response;
  }

}
