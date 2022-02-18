<?php

namespace Mixin;

class Hell
{
    static $hookFile = "hook";
    static $hookAxeFile = "hookAxe";
    static $hookGetFile = "hookGet";
    static $hookDeleteFile = "hookDelete";

    static function error(String $url){
        if(explode('/', $_SERVER['PHP_SELF'])[1] != 'error') die( include dirname(__DIR__, 4)."/error/$url.php" );
    }

    static function array_to_ini(Array $a, Array $parent = array())
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

    static function apiHook(Array $params)
    {
        return api(Hell::$hookFile, $params);
    }

    static function apiAxe(String $model, Array $params = [])
    {
        $params['model'] = $model;
        return api(Hell::$hookAxeFile, $params);
    }

    static function apiGet(String $model, Int $id = null, String $form = null)
    {
        $params = array('model' => $model);
        if($id) $params['id'] = $id;
        if($form) $params['form'] = $form;
        return api(Hell::$hookGetFile, $params);
    }

    static function apiDelete(String $model, Int $id)
    {
        return api(Hell::$hookDeleteFile, array('model' => $model, 'id' => $id));
    }
}

?>