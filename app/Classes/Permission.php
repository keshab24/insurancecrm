<?php

namespace App\Classes;

class Permission 
{
    public function hasAccess($slug)
    {
        if(!empty(session()->get('access_modules'))){
            $flag = false;
            $modules = array_map(function($module){
                return $module['slug'];
            }, session()->get('access_modules'));

            if($modules){
                $flag = in_array($slug, $modules);
            }
            return $flag;        
        } else {
            return 'login';
        }
    }
}