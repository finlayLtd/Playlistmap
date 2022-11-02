<?php

namespace App\Helpers;

class Helpers {

    static function stringsMatchWithAccents($str1, $str2) {
        try {
            $search = explode(",", "ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,ø,Ø,Å,Á,À,Â,Ä,È,É,Ê,Ë,Í,Î,Ï,Ì,Ò,Ó,Ô,Ö,Ú,Ù,Û,Ü,Ÿ,Ç,Æ,Œ");
            $replace = explode(",", "c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,o,O,A,A,A,A,A,E,E,E,E,I,I,I,I,O,O,O,O,U,U,U,U,Y,C,AE,OE");
            
            $newStr1 = str_replace($search, $replace, strtolower($str1));
            $newStr2 = str_replace($search, $replace, strtolower($str2));
            
            return (($newStr1 === $newStr2) || in_array($newStr2, explode(' ', $newStr1)) )? "current" : "";
        } catch (\Throwable $ex) {
            return '';
        }
    }

}
