<?php
/**
 * Created by PhpStorm.
 * User: ULITKA
 * Date: 08.04.2019
 * Time: 11:11
 */

namespace Application\Controllers;


use Application\Service\UserService;
use Bcrypt\Bcrypt;

class UserController extends BaseController
{


    public function RegisterUser(){

        $const = new Constants();

        $userName = $this->request->GetPostValue("userName");

        if(!preg_match($const->NamesPattern, $userName)){

            $this->json(400, array(
                'code'=>400,
                'message'=>"UserName  incorrect",

            ));

            return;
        }//if

        $userPassword = $this->request->GetPostValue('userPass');

        if(!preg_match($const->PasswordPattern, $userPassword)){

            $this->json(400, array(
                'code'=>400,
                'message'=>"UserPass incorrect"
            ));

            return;
        }//if

        $userEmail = $this->request->GetPostValue('userEmail');

        if(!preg_match($const->EmailPattern, $userEmail)){
            $this->json(400, array(
                'code'=>400,
                'message'=>"UserEmail incorrect"
            ));

            return;
        }//if

        $bcrypt = new Bcrypt();
        $bcryptVersion = '2y';

        $heshToken = $bcrypt->encrypt($userEmail, $bcryptVersion);

        $userService = new UserService();

        $typeUser = $const->typeUserRegister;

        $result = $userService->AddUser($userEmail, $userName,$userPassword,$heshToken, $typeUser);

        if($result !== null){ //пользователь добавлен в БД

            $message = new MessageController();

            $message->tuneTemplate($userName,$heshToken);
            $mailres = mail($userEmail , $message->verificationSubject,$message->verificationTemplate,$message->header);


            if($mailres){//если  отправилось сообщение на мыло
                $this->json(200, array(
                    "code"=>200,
                    'message'=>"Пользователь добавлен",

                ));
            }//if
            else{////если не отправилось на мыло
                $this->json(403, array(
                    "code"=>403,
                    'message'=>"Ошибка отправки сообщения",
                ));
            }//else

        }//if
        else{

            $this->json(403, array(
                'code'=>403,
                "message"=>"Пользователь с таким email или логином уже существует",

            ));
        }//else

    }//RegisterUser

    public function VerificationUser(){

        $userService = new UserService();

        $tokenUser = $this->request->GetGetValue('token');

        $userResult = $userService->VerificationUsers($tokenUser);

        if($userResult){
            header('Location: ' . "https://tippradar.com/");
        }//if
//        else{
//            header('Location: ' . "http://google.com");
//        }

    }//VerificationUser

    public function AuthoriseUser(){

        $userService = new UserService();

        $userEmail = $this->request->GetGetValue('userEmail');
        $userPass = $this->request->GetGetValue('userPass');

        $resultAuth = $userService->AuthoriseUsers($userEmail, $userPass);

        $this->json($resultAuth['code'],
            [
                'code'=>$resultAuth['code'],
                'message'=>$resultAuth['message'],
                'mail'=>$userEmail,
                'pass'=>$userPass
            ]
            );

    }//AuthoriseUser

}