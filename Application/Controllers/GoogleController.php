<?php
/**
 * Created by PhpStorm.
 * User: ULITKA
 * Date: 03.04.2019
 * Time: 12:05
 */

namespace Application\Controllers;
use Application\Utils\MySQL;
use Application\Utils\Request;

//require_once '../../vendor/google/apiclient/google-api-php-client/apiClient.php';
//require_once 'includes/google-api-php-client/contrib/apiOauth2Service.php';
//require_once 'includes/idiorm.php';
//require_once 'includes/relativeTime.php';

class GoogleController extends BaseController
{

    public function AuthAction(){


        //unset($_SESSION['upload_token']);
        $client = new \Google_Client();

        $oauth_credentials = __DIR__ . '/../oauth-credentials.json';

//        if (file_exists($oauth_creds)) {
//            return $oauth_creds;
//        }
//
//        return false;


        $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/StacArtem/public/auth';
        var_dump($_SESSION);
        $client->setAuthConfig($oauth_credentials);
        $client->setRedirectUri($redirect_uri);
        $client->addScope(['https://www.googleapis.com/auth/userinfo.email',"https://www.googleapis.com/auth/userinfo.profile"]);




        $authUrl = null;

        if (isset($_GET['code'])) {
            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
            $client->setAccessToken($token);

            // store in the session also
            $_SESSION['upload_token'] = $token;

            // redirect back to the example
            header('Location: ' . $redirect_uri);
        }

        if (!empty($_SESSION['upload_token'])) {
            $client->setAccessToken($_SESSION['upload_token']);
            if ($client->isAccessTokenExpired()) {
                unset($_SESSION['upload_token']);
            }
        } else {
            $authUrl = $client->createAuthUrl();

        }

        var_dump($authUrl);

        $query =  "https://www.googleapis.com/oauth2/v1/userinfo?alt=json&access_token=".$_SESSION['upload_token']['access_token'];
        $json = file_get_contents($query);
        $userInfoArray = json_decode($json,true);

        var_dump($userInfoArray);

        $n = $this->request->GetPostValue("userNAme");

        if(!$n){
            $this->json(array(
                'code' =>400,

                "msg"=>"Имя пользователя обязательно!"

            ));
        }

        $this->json(array(
            'code' =>200,
            'name' =>$userInfoArray[name],
            "msg"=>"авторизация успешна"

        ))
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

            	<a href="<?= $authUrl?>" class="googleLoginButton">Sign in with Google</a>

        </div>


    </body>
</html>
<?php
    }
}