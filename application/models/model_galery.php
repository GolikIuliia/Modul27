<?php
class Model_Galery extends Model
{
  public function get_data()
  { 
    $images=[];
    $images_dir="./images";
    $files=array_diff(scandir($images_dir), array('..', '.'));
    foreach ($files as $file) {
      $images[]='http://study/images/' . $file;      // заменить study.ru на локалхост
      
    }
    return $images;
  }
  public function get_comments()
  {
    $comments = array(); 
    
    foreach($this->get_data() as $image)
    { 
      $image_parts = explode("/", $image);
      $filename = $image_parts[count($image_parts)-1]; //filename

      $comments[$image] = getComments($filename);
    }

    return $comments;
  }
}
?>
