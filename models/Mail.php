<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ContactForm
 *
 * @author halvarez
 */
class ContactForm
{
    private $mail;

    public function __construct()
    {
        require_once (ROOT.'libs/PHPMailerAutoload.php');
        $this->mail = new PHPMailer();
    }

    public function emailBody($email = "partials/email.php"){
       
        ob_start();
        include_once INCLUDES_ROOT.$email;
        return ob_get_clean();
        
    }

    public function contactFormEmail($toName, $toEmail, $fromName, $fromEmail, $msg, $host, $port, $username, $password){
       
        $this->mail->IsSMTP();
        $this->mail->SMTPDebug  = false;
        $this->mail->Port       = $port;
        $this->mail->CharSet    = "UTF-8";
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = $username; //Grab UserName from db
        $this->mail->Password   = $password;              //Grab password from db
        $this->mail->Host       = $host;
        $this->mail->SMTPSecure = "ssl";                 // Only if is secured
        $this->mail->From       = $fromEmail;      //Grab email from db
        $this->mail->FromName   = $fromName;           //Grab Company Name from db or User Name
        $this->mail->addAddress($toEmail, $toName);
        $this->mail->Subject    = "Customer Request";
        $this->mail->Body       = $msg;
        $this->mail->AltBody    = "Allow HTML emails in order to view this one";
        $this->mail->IsHTML(true);
       // $this->mail->msgHTML($msg,  dirname(__FILE__));
        if($this->mail->Send())
        {
            return true;
        }
        else
        {
            error_log($this->mail->ErrorInfo);
            return FALSE;
        }
    }

    public function sendMail($to,$principalName,$subject,$msg,$ccList = array(),$bccList = array())
    {
       
        //$this->mail->IsSMTP();
        $this->mail->SMTPDebug = 3;
        //$this->mail->Port = 587;
        $this->mail->CharSet = "UTF-8";
        $this->mail->SMTPAuth = true;
        $this->mail->Username = "harlenalvarez@gmail.com"; //Grab UserName from db
        $this->mail->Password = "halvarez18";              //Grab password from db
        $this->mail->Host = "smtp.gmail.com";              //
        $this->mail->SMTPSecure = "tls";
        $this->mail->From = "harlenalvarez@gmail.com";      //Grab email from db
        $this->mail->FromName = "Harlen Alvarez";           //Grab Company Name from db or User Name
        $this->mail->addAddress($to,$principalName);
       
        foreach ($ccList as $to => $email)
        {
            $this->mail->addCC($email,$to);
        }
        foreach($bccList as $to => $email)
        {
            $this->mail->addBCC($email,$to);
        }
        $this->mail->Subject = $subject;
        $this->mail->Body = $msg;
        $this->mail->AltBody = "Allow HTML emails in order to view this one";
        $this->mail->IsHTML(true);
       // $this->mail->msgHTML($msg,  dirname(__FILE__));
        if($this->mail->Send())
        {
            return true;
        }
        else
        {
            error_log($this->mail->ErrorInfo);
            return FALSE;
        }
    }

    public function sendErrorMail($subject,$msg)
    {

        $this->mail->IsSMTP();
        $this->mail->SMTPDebug = false;
        $this->mail->Port = 465;
        $this->mail->CharSet = "UTF-8";
        $this->mail->SMTPAuth = true;
        $this->mail->Username = "dwmailman";            //Grab UserName from db
        $this->mail->Password = "1234qwer";             //Grab password from db
        $this->mail->Host = "mail.dw.com";              //
        $this->mail->SMTPSecure = "ssl";
        $this->mail->From = "harlenalvarez@gmail.com";      //Grab email from db
        $this->mail->FromName = "System Error";           //Grab Company Name from db or User Name
        $this->mail->addAddress("harlenalvarez@gmail.com","Harlen Alvarez");
        $this->mail->Subject = $subject;
        $this->mail->Body = $msg."<br/>User requesting is ".$_SESSION['user_main_emial']."<br/>Date and Time: ".date("Y-m-d H:m:s");
        $this->mail->AltBody = "Allow HTML emails in order to view this one";
        $this->mail->IsHTML(true);
        // $this->mail->msgHTML($msg,  dirname(__FILE__));
        if($this->mail->Send())
        {
            return true;
        }
        else
        {
            error_log($this->mail->ErrorInfo);
            return FALSE;
        }
    }
}
