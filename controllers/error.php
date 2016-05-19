<?php
/**
 * User: harlenalvarez
 * Date: 11/6/15
 * Time: 9:28 PM
 */
class Error extends Controller
{

    function __construct($params = array())
    {
       parent::__construct($params);

    }
    
    function index()
    {
        $this->view->render("error/index");

    }

    function paymentRequested(){
        $this->view->render("error/paymentRequest");
    }

    function restricted(){
        $this->view->render("error/restricted");
    }

    public function loadPage($page = "error/index")
    {
        //TODO: Implement loadPage() method
        $this->view->render($page,$this->params);
    }

    function construction($page = "construction"){
        $pageInfo = file_get_contents(ROOT_SITE_FOLDER."home.json");

        $pageInfo = json_decode($pageInfo,true);
        foreach($pageInfo as $key => $value){
            $this->params[$key] = $value;
        }
        $this->view->renderError($page,$this->params);
    }
}

