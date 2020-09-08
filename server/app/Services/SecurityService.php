<?php


namespace App\Services;


class SecurityService
{
    public static function encryptToArgon($password)
    {
        return \password_hash($password, PASSWORD_ARGON2I);
    }
    public static function verify($password, $hash)
    {
        return \password_verify($password, $hash);
    }

}