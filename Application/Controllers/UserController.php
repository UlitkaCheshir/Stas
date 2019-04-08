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

        $userLogin = $this->request->GetPostValue("userLogin");

        if(!preg_match($const->LoginPattern, $userLogin)){

            $this->json(400, array(
                'code'=>400,
                'message'=>"Логин неверный",
                'userl'=>$userLogin
            ));

            return;
        }//if

        $userPassword = $this->request->GetPostValue('userPass');

        if(!preg_match($const->PasswordPattern, $userPassword)){

            $this->json(400, array(
                'code'=>400,
                'message'=>"Пароль не соответсвует"
            ));

            return;
        }//if

        $userEmail = $this->request->GetPostValue('userEmail');

        if(!preg_match($const->EmailPattern, $userEmail)){
            $this->json(400, array(
                'code'=>400,
                'message'=>"Email не соответсвует"
            ));

            return;
        }//if

        $bcrypt = new Bcrypt();
        $bcryptVersion = '2y';

        $heshToken = $bcrypt->encrypt($userEmail, $bcryptVersion);

        $userService = new UserService();

        $typeUser = $const->typeUserRegister;

        $result = $userService->AddUser($userEmail,$userLogin,null,$userPassword,$heshToken, $typeUser);

        if($result !== null){ //пользователь добавлен в БД

            //здесь должна быть отправка на почту для аунтефикации

            $this->json(200, array(
                "code"=>200,
                'message'=>"Пользователь добавлен",

            ));
        }//if
        else{

            $this->json(403, array(
                'code'=>403,
                "message"=>"Пользователь с таким email или логином уже существует",

            ));
        }//else

    }//RegisterUser

}