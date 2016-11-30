<?php
 
/**
 * @file
 * Contains \Drupal\business\Controller\AjaxPaginationController
 */
 
namespace Drupal\ajaxpagination\Controller;
 
use Drupal\Core\Controller\ControllerBase;
use Drupal\image\Entity\ImageStyle;
 use Drupal\Core\Url; 
/**
 * Controller routines for theme example routes.
 */
class AjaxPaginationController extends ControllerBase {
 
    /**
   * blogajax
   * @return string
   * Load the last article
   */ 
    
  public function blogajax() {
    $content= "";
    $id= "";
     
    $loop = $this->node_load_by_type(20);
    
    $content = $this-> return_html_loop($loop);

       return [
         'example one' => [
           '#theme' => 'test_twig',
           '#loop' => $this->t($content["content"]),  
           '#id' => $content["id"],
           '#image_style'=>""   
         ] 
       ];

  }
  
  public function return_html_loop($loop){
      $content= "";
       $id= "";
       $options = ['absolute' => TRUE];
     foreach ($loop as $val) {
        $id =$val->id();
        $url_object =  "/node/".$val->id() ; //new Url('node.view', array('node' => $val->id()), array('fragment' => 'main-content'));

        $content .= '<div class="post_list">
                  <div class="first_type">  
                          <img class="inner_cat_img" src="'.ImageStyle::load('large')->buildUrl($val->get('field_image')->entity->uri->value).'" title=" " /> 
                        <div class="border_arround_picture"></div>
                      <a class="link_ittem" href="'.$url_object.'"></a>   
                      <div class="inner_postlist" style="width: 100%;">  
                          <h3>
                            <a href="'.$url_object.'" class="go_to_link"> '. $val->label() .'</a>
                          </h3>  
                      </div>
                  </div>     
              </div>';
     }
     return array('id'=>$id, "content"=>$content );
      
  }
  
  
  
  /**
   * node_load_by_type
   * @param  int $limit
   * @param  int $id
   * @return array
   */  
  
function node_load_by_type($limit = 1, $id = 0) {
   $nids = \Drupal::entityQuery('node')
   ->condition('type', 'article')
   ->sort('nid', 'DESC')
   ->range(0, $limit) ;
  if(!empty($id)){ 
   $nids = $nids->condition('nid', $id, '<');
  }
   $nids = $nids->execute(); 
   
 $nodes = \Drupal::entityTypeManager()
   ->getStorage('node')
   ->loadMultiple($nids);
  return $nodes;
}
  
  /**
   * ajaxcall
   * @param  int $id
   * @return string
   */
  public function ajaxcall($id){
     $show= $this->node_load_by_type(10, $id);
       if($show){
         $content = $this-> return_html_loop($show); 
         
      }else{
         $content = array('id'=>"9999999", "content"=> "" );  
      }   
       echo json_encode($content);
       exit();
  }
 
  
}

