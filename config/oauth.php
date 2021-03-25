<?php

return [

    'authorize_url'     =>  env('OAUTH_SERVER').env('OAUTH_AUTHORIZE_PATH','/oauth/authorize'),
    'request_token_url' =>  env('OAUTH_SERVER').env('OAUTH_REQUEST_TOKEN_PATH','/oauth/token'),
    'request_user_url'  =>  env('OAUTH_SERVER').env('OAUTH_REQUEST_USER_PATH','/api/user'),

    'callback_redirect_url'      =>  env('CALLBACK_REDIRECT_URI'),
    'client_id'         =>  env('CLIENT_ID'),
    'client_secret'     =>  env('CLIENT_SECRET'),

];