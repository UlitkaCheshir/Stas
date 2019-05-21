<?php
/**
 * Created by PhpStorm.
 * User: ULITKA
 * Date: 11.04.2019
 * Time: 12:47
 */

namespace Application\Controllers;


class MessageController
{

    public $verificationSubject = "Trippradar";
    public $verificationTemplate = null;

    public $header = "From: tripp_mail@tippradar.com\r\n";




    public function tuneTemplate($userName,$hesh){

        $this->header .='X-Mailer: PHP/' . phpversion();
        $this->header .= "MIME-Version: 1.0\r\n";
        $this->header.="Content-type: text/html; charset=iso-8859-1\r\n";
        $this->verificationTemplate = "<h3>$userName</h3> </br> <a href=http://tippradar.com/php/public/verification/?token=$hesh>Confirm</a>";
    }//
}