<?php
/**
 * Created by PhpStorm.
 * User: ulitk
 * Date: 21.05.2019
 * Time: 21:52
 */

namespace Application\Controllers;


class FeedBackController extends BaseController
{

    public function AddFeedback(){

        $const = new Constants();

        $userName = $this->request->GetPostValue('userName');

        if(!preg_match($const->NamesPattern, $userName)){

            $this->json(400, array(
                'code'=>400,
                'message'=>"UserName  incorrect",

            ));

            return;
        }//if

        $userEmail = $this->request->GetPostValue('userEmail');

        if(!preg_match($const->EmailPattern, $userEmail)){

            $this->json(400, [
                'code'=>400,
                'message'=>'UserEmail incorrect'
            ]);
        }//if

        $userPhone = $this->request->GetPostValue('userPhone');

        $userText = $this->request->GetPostValue('feedBackMessage');

        if(!preg_match($const->textFeedBackPattern, $userText)){
            $this->json(400, [
                'code'=>400,
                'message'=>'UserText incorrect'
            ]);
        }
    }//AddFeedback
}