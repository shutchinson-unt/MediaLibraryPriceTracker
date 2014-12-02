<?php

require_once 'protected/components/vendor/password_compat/lib/password.php';

class Password
{
    public static function hash($password, $cost)
    {
        return password_hash($password, PASSWORD_BCRYPT, array('cost' => $cost));
    }

    public static function verify($password, $hash)
    {
        return password_verify($password, $hash);
    }
}

$hash = Password::hash('demo', 12);
var_dump($hash);
var_dump(Password::verify('demo', $hash));


