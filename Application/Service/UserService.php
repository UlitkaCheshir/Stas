<?php
/**
 * Created by PhpStorm.
 * User: ULITKA
 * Date: 04.04.2019
 * Time: 13:28
 */

namespace Application\Service;

use Application\Utils\MySQL;
use Bcrypt\Bcrypt;


use \RedBeanPHP\R as R;

class UserService
{

    public function AddUser(){

        $user = R::dispense( 'users' );
        $user->email = "bla111111";
        $user->name = "blaBla";

        if(!$this->GetUser('bla111111')){
            $id = R::store( $user );
            return $id;
        }

        return null;
    }//AddUser

    public function GetUser($parametr){

        $user = R::findOne( 'users', ' email = ? OR id = ?  ', [

            [ $parametr, \PDO::PARAM_STR ],
            [ $parametr, \PDO::PARAM_INT]
        ] );

        return $user;

    }//GetUser
}