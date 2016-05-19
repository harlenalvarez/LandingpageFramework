<?php
/**
 * User: harlenalvarez
 * Date: 11/6/15
 * Time: 9:28 PM
 */

class Home extends Controller{

    public function __construct($params = array()){
        parent::__construct($params);
    }

    public function loadPage($page="index/home"){
        if(isset($_POST['contactFormSubmitButton'])){
            $msg = "";
            parent::getModel("Mail");
            $mail = new ContactForm();
            if(isset($_POST['phoneNumber']) && !empty($_POST['phoneNumber'])){
                $msg = "<p>Phone Number: ".$_POST['phoneNumber']."</p>";
            }

            $msg .= "<p>".$_POST['comment']."</p>";
            $msg = $this->model->sanitizeScriptTags($msg);
            $es = file_get_contents(ROOT_SITE_FOLDER."email.json");
            $es = json_decode($es, true);
            $mail->contactFormEmail($es['name'],$es['email'],$_POST['name'],$_POST['email'],$msg,$es['host'],$es['port'],$es['username'],$es['password']);
            $this->redirectTo("home");
        }
        $this->params['currentPage'] = "home";
        $pageInfo = file_get_contents(ROOT_SITE_FOLDER."home.json");
        $this->params["pagejson"] = $pageInfo;
        $pageInfo = json_decode($pageInfo,true);
        foreach($pageInfo as $key => $value){
            $this->params[$key] = $value;
        }
        if($this->params['construction']){
            $this->redirectTo("error/construction");
        }
        $this->view->render($page,$this->params);
    }

    public function sendMessage(){

    }

}


