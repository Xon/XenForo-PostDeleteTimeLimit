<?php

class SV_PostDeleteTimeLimit_Listener
{
    public static function load_class($class, array &$extend)
    {
        $extend[] = 'SV_PostDeleteTimeLimit_'.$class;
    }
}