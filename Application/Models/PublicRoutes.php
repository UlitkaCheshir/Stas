<?php


return array(
    'get' => [
        '/auth' => 'GoogleController@AuthAction',
        '/logout' => 'GoogleController@LogoutAction',
        '/authFace' => 'FaceBookController@AuthFaceBook',
    ],
    'post' => [
        '/registerUser' => 'UserController@RegisterUser',
    ],
    'delete' => [

    ],
    'put' => [

    ]

);

