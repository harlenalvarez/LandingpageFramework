<?php
class View 
{
    var $userId;

    public function __construct()
    {
        if (isset($_SESSION['user_id']))
        {
            $this->userId = $_SESSION['user_id'];
            //$this->userFirstName = $_SESSION[''];
        }
        $this->model = new Model();
    }

    /**
     * @param String $name
     * @param Array $params
     * @param boolean $requiresAuth
     * @return void Includes necessary files to display site
     */
    public function render($name, $params = array(), $requiresAuth = false)
    {

        require_once(ROOT_INCLUDES . "inc_Head.php");
        if (isset($params['action']) && $params['action'])
        {
            echo $this->showResponse($params['status'], $params['message']);
        }
        require_once(ROOT . "views/" . $name . ".php");
        require_once(ROOT_INCLUDES . "inc_Foot.php");
    }

    /**
     * 
     * @param String $name
     * @param Array $params (array is what ever follows the uri name after the function)
     * @return void (It just includes a piece of page)
     */
    public function partialRender($name, $params = array())
    {
        include(ROOT . "views/includes/partials/" . $name);
    }

    public function renderError($name, $params = array()){

        require_once(ROOT."views/error/".$name.".php");
    }

    /**
     * @param String $status
     * @param String $msg
     * @return String (returns a html string to display)
     */
    public function showResponse($status, $msg)
    {
        $status = strtolower($status);
        switch ($status)
        {
            case "error":
                $html = $this->showError($msg);
                break;
            case "success":
                $html = $this->showSuccess($msg);
                break;
            case "warning":
                $html = $this->showWarning($msg);
                break;
            default:
                $html = $this->showError("Incorrect response type");
                break;
        }
        return $html;
    }

    /**
     * @param Sting $msg
     * @return String (Returns an html string to dispay)
     */
    public function showError($msg)
    {
        $html = file_get_contents(ROOT_INCLUDES . "partials/error.html");
        $html = str_replace(":message", $msg, $html);
        return $html;
    }

    /** 
     * @param String $msg
     * @return STRING (Returns an html string to display)
     */
    public function showSuccess($msg)
    {
        $success = file_get_contents(ROOT_INCLUDES . "partials/success.html");
        $success = str_replace(":message", $msg, $success);
        return $success;
    }

    /**
     * @param String $msg
     * @return STRING (Returns an html string to display)
     */
    public function showWarning($msg)
    {
        $success = file_get_contents(ROOT_INCLUDES . "partials/warning.html");
        $success = str_replace(":message", $msg, $success);
        return $success;
    }

    /**
     * @param String $page
     * @return STRING 
     */
    public function checkAuth($page)
    {
        if (empty($this->view->userId))
        {
            return "index/login";
        } else
        {
            return $page;
        }
    }

}