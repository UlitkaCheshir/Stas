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

            $isUser = MySQL::$db->prepare("SELECT * FROM users WHERE userLogin = :userLogin OR userEmail=:userEmail");
            $isUser->bindParam(':userLogin', $userLogin,\PDO::PARAM_STR);
            $isUser->bindParam(':userEmail', $userEmail,\PDO::PARAM_STR);
            $isUser->execute();

            $result = $isUser->fetchAll(\PDO::FETCH_OBJ);

            if(!$result){

                $bcrypt = new Bcrypt();
                $bcrypt_version = '2y';
                $heshPassword = $bcrypt->encrypt($userPassword,$bcrypt_version);

                $stm = MySQL::$db->prepare("INSERT INTO users (userEmail, userName, userLogin, userPassword, userHash, verification, status_id, type_id)
                                            VALUES(  :email , default , :login,  :password , :hash, false, :status, :type )");
                $stm->bindParam(':login' , $userLogin , \PDO::PARAM_STR);
                $stm->bindParam(':email' , $userEmail , \PDO::PARAM_STR);
                $stm->bindParam(':hash' , $userHash , \PDO::PARAM_STR);
                $stm->bindParam(':password' , $heshPassword , \PDO::PARAM_STR);
                $stm->bindParam(':status' , $const->statusNOVIP , \PDO::PARAM_INT);
                $stm->bindParam(':type' , $userType , \PDO::PARAM_INT);
                $stm->execute();

                return  MySQL::$db->lastInsertId();

            }//if

            return null;

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