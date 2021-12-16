<?php

namespace Mixin;

class Hell
{
    static function error($url){
        if(explode('/', $_SERVER['PHP_SELF'])[1] != 'error'){
            header("location:".DIR."/error/$url".EXT);
            exit;
        }
    }

    static function array_to_ini(array $a, array $parent = array())
    {
        $out = '';
        foreach ($a as $k => $v)
        {
            if (is_array($v))
            {
                //subsection case
                $sec = array_merge((array) $parent, (array) $k);
                $out .= PHP_EOL;
                $out .= '[' . join('.', $sec) . ']' . PHP_EOL;
                $out .= Hell::array_to_ini($v, $sec);
            }
            else
            {
                //plain key->value case
                $out .= "$k=$v" . PHP_EOL;
            }
        }
        return $out;
    }
}

?>