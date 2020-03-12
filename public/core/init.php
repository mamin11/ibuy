<?php
session_start();

$GLOBALS['config'] = array(
    'mysql' => array(
       'host' => 'v.je',
       'username' => 'student',
       'password' => 'student',
       'db' => 'webass1'
    ),
    'remember' => array(
        'cookie_name' => 'hash',
        'cookie_expiry' => 86400 
    ),
    'session' => array(
        'session_name' => 'user',
        'token_name' => 'token'
    )
);

spl_autoload_register(function($class){
    require_once 'classes/' . $class . '.php';
});

require_once 'functions/sanitize.php';

if(Cookie::exists(Config::get('remember/cookie_name')) && !Session::exists(Config::get('session/session_name'))){
//  echo 'user asked to be remembered';
    $hash = Cookie::get(Config::get('remember/cookie_name'));
    $hashcheck = DB::getInstance()->getAll('webass1.users_session', array('hash', '=', $hash));

    if($hashcheck->count()){
        // echo 'hash matched, log user in';
        $user = new User($hashcheck->first()->user_id);
        $user->login();
    }
}