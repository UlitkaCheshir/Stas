<?php


return array(
    'get' => [
        '/auth' => 'GoogleController@AuthAction',
        '/logout' => 'GoogleController@LogoutAction',
        '/authFace' => 'FaceBookController@AuthFaceBook',
        '/verification' => 'UserController@VerificationUser',
        '/authUser' => 'UserController@AuthoriseUser',
    ],
    'post' => [
        '/registerUser' => 'UserController@RegisterUser',
    ],
    'delete' => [

    ],
    'put' => [

    ]

);

