<?php

namespace Security\Service;

class PasswordGenerator
{
    /**
     * 
     * @param strimg $plainPassword
     * @param string $salt
     * @return array
     */
    public static function generate($plainPassword, $salt = null)
    {
        if ($salt === null) {
           $salt = substr(md5(rand()), 7, 12); 
        }
        
        $password = sha1($plainPassword . $salt);
        
        return ["password" => $password, "salt" => $salt];
    }
}
