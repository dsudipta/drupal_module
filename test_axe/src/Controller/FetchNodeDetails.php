<?php
  /**
   * Created by PhpStorm.
   * User: sudipta
   * Date: 26/2/19
   * Time: 11:30 PM
   */
  
  namespace Drupal\test_axe\Controller;
  
  use \Drupal\node\Entity\Node;
  use \Symfony\Component\HttpFoundation\Response;
  
  class FetchNodeDetails
  {
    public function getContent($api_key,$node_id){
      $node = Node::load($node_id);
      if($api_key != \Drupal::state()->get('siteapikey')){
        throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException();
      }
      elseif($node == NULL || $node->bundle() != "page"){
        throw new \Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException();
      }
      else{
        $node_response = \Drupal::service("serializer")->serialize($node, 'json', ['plugin_id'=>'entity']);
        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent($node_response);
        return $response;
      }
    }
  }