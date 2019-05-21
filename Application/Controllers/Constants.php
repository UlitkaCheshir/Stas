<?php
/**
 * Created by PhpStorm.
 * User: ULITKA
 * Date: 03.04.2019
 * Time: 11:47
 */

namespace Application\Controllers;


class Constants
{

    public $NamesPattern = '/^[a-zа-я]{2,50}$/iu';
    public $EmailPattern = '/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/i';
    public $PasswordPattern = '/^[a-z0-9_?!^%()\d]{6,30}$/i';

    public $statusVIP = 1;
    public $statusNOVIP = 2;

    public $typeUserGoogle = 1;
    public $typeUserFacebook = 2;
    public $typeUserRegister = 3;


}