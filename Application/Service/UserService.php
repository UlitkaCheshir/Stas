<?php
/**
 * Created by PhpStorm.
 * User: ULITKA
 * Date: 04.04.2019
 * Time: 13:28
 */

namespace Application\Service;

use Application\Controllers\Constants;
use Application\Utils\MySQL;
use Bcrypt\Bcrypt;


use \RedBeanPHP\R as R;

class UserService
{

    public function AddUser($userEmail,$userLogin, $userName, $userPassword, $userHash, $userType){

        $const = new Constants();

        if($userType !== $const->typeUserRegister){ //если пользователь с гугла или фейсбук

            $user = R::dispense( 'users' );
            $user->useremail = $userEmail;
            $user->username = $userName;

            if(!$this->GetUser($userEmail)){
                $id = R::store( $user );
                return $id;
            }//if

            return null;
        }//if
        else{ // если пользователь просто регистрируеться

            $resultFind  = $this->GetUser($userEmail, $userLogin);

           if(!$resultFind){//если пользователь не найден в БД

               $bcrypt = new Bcrypt();
               $bcrypt_version = '2y';
               $heshPassword = $bcrypt->encrypt($userPassword,$bcrypt_version);

               $user = R::dispense( 'users' );
               $user->useremail = $userEmail;
               $user->userlogin = $userLogin;
               $user->userhash = $userHash;
               $user->userpassword = $heshPassword;

               $statusBean = R::load('statususeraccount', $const->statusNOVIP);
               $statusBean->ownUsers = array($user);
               R::store($statusBean);

               $typeBean = R::load('typeuseraccount', $userType);
               $typeBean->ownUsers = array($user);
               R::store($typeBean);

               $id = R::store( $user );
               return $id;

           }//if
            else{
                return null;
            }//else

        }//else

    }//AddUser

    public function GetUser($parametr, $userLogin){

        $user = R::findOne( 'users', ' useremail = ? OR id = ? OR userlogin = ? ', [

            [ $parametr, \PDO::PARAM_STR ],
            [ $parametr, \PDO::PARAM_INT],
            [ $userLogin, \PDO::PARAM_STR ],
        ] );

        return $user;

    }//GetUser
}