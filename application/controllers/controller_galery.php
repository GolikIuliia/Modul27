<?php
class Controller_galery extends Controller
{
 
    function index()
    {   
        $this->model = new Model_Galery();
        $data = array(); 
        $data['title'] = 'Галерея'; 
        $data['authed'] = isset($_SESSION["user.authed"]) ? $_SESSION["user.authed"] : false;
        $data['name'] = isset($_SESSION["user.name"]) ? $_SESSION["user.name"] : false;

        $data['images'] = $this->model->get_data();
        $data['comments'] = $this->model->get_comments();
        $this->view->generate('galery_view.php', $data);
    }
    public function comment_add()
    {
        if($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION["user.authed"]) || !$_SESSION["user.authed"]) return;
        $name = $_SESSION['user.name'];
        $comment = $_POST['comment'];
        $image = $_POST['image_id']; 
        $date =  date("F j, Y, g:i a");

        $image = explode("/", $image);
        $filename = $image[count($image)-1]; //filename

        $info =  [$name, $filename, $comment, $date];
        
        $cback = insertComment($info);
        echo json_encode($cback);
        
    }

    public function comment_remove()
    {
        if($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION["user.authed"]) || !$_SESSION["user.authed"]) return;
        
        $comment = $_POST['comment'];
    
        $cback = deleteComments($comment);
        echo json_encode($cback);
        
    }

    public function image_delete()
    {
        if($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION["user.authed"]) || !$_SESSION["user.authed"]) return;
        $image = $_POST['image'];
        $cback = deleteImage($image);

        echo json_encode($cback);
    }
}