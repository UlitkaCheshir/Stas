<?php
/**
 * Created by PhpStorm.
 * User: ULITKA
 * Date: 05.04.2019
 * Time: 12:30
 */

namespace Application\Controllers;


class FaceBookController
{
    public function AuthFaceBook(){

        $path = "https://www.facebook.com/v3.2/dialog/oauth?client_id=".ID_FACEBOOK."&redirect_uri=".URL_REDIRECT_FACEBOOK."&response_type=code&scope=public_profile,email,user_location";
       

        ?>


        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="utf-8" />
            <title>Google Powered Login Form | Tutorialzine Demo</title>

        </head>

        <body>

        <h1>Login Form</h1>
        <div id="main">

                <a href="<?= $path?>" class="googleLoginButton">Sign in with FaceBook</a>

        </div>


        </body>
        </html>
        <?php

    }//AuthFaceBook
}